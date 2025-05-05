/**
 * E-Learning Platform Chat Functionality
 * This script provides real-time updates and interactive features for the chat system
 */

// Global variables
let lastMessageId = 0;
let isPolling = false;
let pollInterval = 5000; // 5 seconds
let pollTimer = null;
let typingTimer = null;
let typingStatus = false;
let lastTypingTime = 0;
const USER_TYPING_TIMEOUT = 3000; // 3 seconds

// DOM elements
const messageContainer = document.getElementById('messageContainer');
const messageForm = document.getElementById('messageForm');
const messageInput = document.getElementById('messageInput');
const typingIndicator = document.getElementById('typingIndicator');
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Get the user ID from the URL query parameter
const urlParams = new URLSearchParams(window.location.search);
const chatUserId = urlParams.get('user_id');

// Initialize chat functionality when document is ready
document.addEventListener('DOMContentLoaded', function() {
  // Initialize
  initializeChat();
  
  // Add event listeners
  if (messageForm) {
    messageForm.addEventListener('submit', sendMessage);
  }
  
  if (messageInput) {
    messageInput.addEventListener('keyup', handleTyping);
  }
  
  // Set up polling for new messages
  startPolling();
  
  // Scroll to bottom of message container
  scrollToBottom();
  
  // Initialize emoji picker
  initEmojiPicker();
  
  // Initialize file upload
  initFileUpload();
  
  // Mark messages as read when chat is opened
  markMessagesAsRead();
});

/**
 * Initialize chat functionality
 */
function initializeChat() {
  // Set the last message ID
  const messageElements = document.querySelectorAll('.message-bubble');
  if (messageElements.length > 0) {
    const lastElement = messageElements[messageElements.length - 1];
    lastMessageId = parseInt(lastElement.getAttribute('data-message-id')) || 0;
  }
  
  // Setup page visibility change detection
  document.addEventListener('visibilitychange', handleVisibilityChange);
  
  // Handle clicking outside emoji picker to close it
  document.addEventListener('click', function(e) {
    const emojiPicker = document.getElementById('emojiPicker');
    const emojiButton = document.getElementById('emojiButton');
    
    if (emojiPicker && emojiButton && !emojiPicker.contains(e.target) && !emojiButton.contains(e.target)) {
      emojiPicker.classList.remove('show');
    }
  });
  
  // Mobile: Back button for sidebar
  const showSidebarBtn = document.getElementById('showSidebarBtn');
  if (showSidebarBtn) {
    showSidebarBtn.addEventListener('click', function() {
      const sidebar = document.querySelector('.chat-sidebar');
      if (sidebar) {
        sidebar.classList.toggle('active');
      }
    });
  }
}

/**
 * Handle page visibility changes (focus/blur)
 */
function handleVisibilityChange() {
  if (document.visibilityState === 'visible') {
    // User has returned to the page, mark messages as read
    markMessagesAsRead();
    
    // Restart polling with shorter interval
    startPolling(2000);
  } else {
    // User left the page, slow down polling
    stopPolling();
    startPolling(10000);
  }
}

/**
 * Start polling for new messages
 */
function startPolling(interval = pollInterval) {
  if (pollTimer) {
    clearInterval(pollTimer);
  }
  
  // Only start if we have a chat user
  if (!chatUserId) return;
  
  pollInterval = interval;
  isPolling = true;
  
  // Check immediately, then set interval
  checkForNewMessages();
  
  pollTimer = setInterval(function() {
    if (isPolling) {
      checkForNewMessages();
    }
  }, pollInterval);
}

/**
 * Stop polling for new messages
 */
function stopPolling() {
  isPolling = false;
  if (pollTimer) {
    clearInterval(pollTimer);
    pollTimer = null;
  }
}

/**
 * Check for new messages via AJAX
 */
function checkForNewMessages() {
  if (!chatUserId || !csrfToken) return;
  
  const formData = new FormData();
  formData.append('operation', 'get_new_messages');
  formData.append('user_id', chatUserId);
  formData.append('last_message_id', lastMessageId);
  formData.append('csrf_token', csrfToken);
  
  fetch('message_operations.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.status === 'success' && data.messages && data.messages.length > 0) {
      // Update the UI with new messages
      appendNewMessages(data.messages, data.current_user_id);
      
      // Update last message ID
      const newLastMessageId = data.messages[data.messages.length - 1].id;
      if (newLastMessageId > lastMessageId) {
        lastMessageId = newLastMessageId;
      }
      
      // Play sound notification
      playNotificationSound();
      
      // Mark messages as read
      markMessagesAsRead();
    }
    
    // Check if the other user is typing
    if (data.typing_status === true) {
      showTypingIndicator();
    } else {
      hideTypingIndicator();
    }
  })
  .catch(error => {
    console.error('Error checking for new messages:', error);
  });
}

/**
 * Append new messages to the chat container
 */
function appendNewMessages(messages, currentUserId) {
  if (!messageContainer || messages.length === 0) return;
  
  let currentDate = getCurrentDateFromUI();
  
  messages.forEach(message => {
    const messageDate = new Date(message.sent_at).toISOString().split('T')[0];
    
    // Check if we need a new date separator
    if (messageDate !== currentDate) {
      currentDate = messageDate;
      const dateElement = createDateSeparator(message.sent_at);
      messageContainer.appendChild(dateElement);
    }
    
    // Create message element
    const messageElement = createMessageElement(message, currentUserId);
    messageContainer.appendChild(messageElement);
  });
  
  // Scroll to the bottom
  scrollToBottom();
}

/**
 * Create a date separator element
 */
function createDateSeparator(timestamp) {
  const messageDate = new Date(timestamp);
  const today = new Date();
  const yesterday = new Date(today);
  yesterday.setDate(yesterday.getDate() - 1);
  
  let dateDisplay = '';
  if (messageDate.toDateString() === today.toDateString()) {
    dateDisplay = 'Today';
  } else if (messageDate.toDateString() === yesterday.toDateString()) {
    dateDisplay = 'Yesterday';
  } else {
    const options = { month: 'long', day: 'numeric', year: 'numeric' };
    dateDisplay = messageDate.toLocaleDateString(undefined, options);
  }
  
  const dateElement = document.createElement('div');
  dateElement.className = 'info-message animate__animated animate__fadeIn';
  dateElement.textContent = dateDisplay;
  
  return dateElement;
}

/**
 * Create a message bubble element
 */
function createMessageElement(message, currentUserId) {
  const isSent = parseInt(message.sender_id) === parseInt(currentUserId);
  const messageClass = isSent ? 'message-sent animate__animated animate__fadeInRight' : 'message-received animate__animated animate__fadeInLeft';
  
  const messageElement = document.createElement('div');
  messageElement.className = `message-bubble ${messageClass}`;
  messageElement.setAttribute('data-message-id', message.id);
  
  // Message text with line breaks preserved
  const messageText = document.createElement('div');
  messageText.className = 'message-text';
  messageText.innerHTML = message.message_text.replace(/\n/g, '<br>');
  messageElement.appendChild(messageText);
  
  // Message time
  const messageTime = document.createElement('div');
  messageTime.className = 'message-time';
  const messageDate = new Date(message.sent_at);
  messageTime.textContent = messageDate.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
  messageElement.appendChild(messageTime);
  
  // Message status (for sent messages)
  if (isSent) {
    const messageStatus = document.createElement('div');
    messageStatus.className = 'message-status';
    messageStatus.innerHTML = message.is_read ? 
      '<i class="ti ti-checks text-primary"></i>' : 
      '<i class="ti ti-check"></i>';
    messageElement.appendChild(messageStatus);
  }
  
  // Handle attachments if present
  if (message.attachment) {
    const attachmentElement = createAttachmentElement(message.attachment);
    messageElement.appendChild(attachmentElement);
  }
  
  return messageElement;
}

/**
 * Create an attachment element
 */
function createAttachmentElement(attachment) {
  const attachmentContainer = document.createElement('div');
  attachmentContainer.className = 'message-attachment';
  
  const fileExt = attachment.file_name.split('.').pop().toLowerCase();
  
  // Check if it's an image
  if (['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'].includes(fileExt)) {
    const image = document.createElement('img');
    image.src = `../../uploads/chat/${attachment.file_path}`;
    image.alt = attachment.file_name;
    image.className = 'img-fluid rounded cursor-pointer';
    
    // Add click handler to open full image
    image.addEventListener('click', function() {
      openImageViewer(image.src);
    });
    
    attachmentContainer.appendChild(image);
  } else {
    // For other file types, show a download link
    const fileLink = document.createElement('a');
    fileLink.href = `../../uploads/chat/${attachment.file_path}`;
    fileLink.className = 'file-attachment';
    fileLink.setAttribute('download', attachment.file_name);
    
    const iconClass = getFileIconClass(fileExt);
    
    fileLink.innerHTML = `
      <div class="file-icon">
        <i class="${iconClass}"></i>
      </div>
      <div class="file-info">
        <div class="file-name">${attachment.file_name}</div>
        <div class="file-size">${formatFileSize(attachment.file_size)}</div>
      </div>
    `;
    
    attachmentContainer.appendChild(fileLink);
  }
  
  return attachmentContainer;
}

/**
 * Get appropriate icon class based on file extension
 */
function getFileIconClass(extension) {
  const iconMap = {
    'pdf': 'ti ti-file-pdf',
    'doc': 'ti ti-file-text',
    'docx': 'ti ti-file-text',
    'xls': 'ti ti-file-spreadsheet',
    'xlsx': 'ti ti-file-spreadsheet',
    'ppt': 'ti ti-presentation',
    'pptx': 'ti ti-presentation',
    'zip': 'ti ti-file-zip',
    'rar': 'ti ti-file-zip',
    'mp3': 'ti ti-file-music',
    'wav': 'ti ti-file-music',
    'mp4': 'ti ti-file-video',
    'avi': 'ti ti-file-video',
    'txt': 'ti ti-file-text',
    'csv': 'ti ti-file-csv'
  };
  
  return iconMap[extension] || 'ti ti-file';
}

/**
 * Format file size to human-readable format
 */
function formatFileSize(bytes) {
  if (bytes === 0) return '0 Bytes';
  
  const k = 1024;
  const sizes = ['Bytes', 'KB', 'MB', 'GB'];
  const i = Math.floor(Math.log(bytes) / Math.log(k));
  
  return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

/**
 * Send a message via AJAX
 */
function sendMessage(e) {
  e.preventDefault();
  
  if (!messageInput || !chatUserId || !csrfToken) return;
  
  const messageText = messageInput.value.trim();
  if (!messageText) return;
  
  // Get file upload if any
  const fileInput = document.getElementById('fileUpload');
  const hasFile = fileInput && fileInput.files.length > 0;
  
  // Create form data
  const formData = new FormData();
  formData.append('operation', 'send_message');
  formData.append('recipient_id', chatUserId);
  formData.append('message', messageText);
  formData.append('csrf_token', csrfToken);
  
  // Add file if present
  if (hasFile) {
    formData.append('attachment', fileInput.files[0]);
  }
  
  // Show loading state
  messageInput.setAttribute('disabled', 'disabled');
  const sendButton = messageForm.querySelector('button[type="submit"]');
  sendButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
  sendButton.setAttribute('disabled', 'disabled');
  
  fetch('message_operations.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.status === 'success') {
      // Clear input
      messageInput.value = '';
      
      // Reset file input
      if (hasFile) {
        fileInput.value = '';
        document.getElementById('filePreview').innerHTML = '';
        document.getElementById('filePreview').classList.add('hidden');
      }
      
      // Append new message
      appendNewMessages([data.message], data.current_user_id);
      
      // Update last message ID
      lastMessageId = data.message.id;
      
      // Reset typing status
      typingStatus = false;
      updateTypingStatus(false);
    } else {
      showAlert('Error sending message: ' + data.message, 'danger');
    }
  })
  .catch(error => {
    console.error('Error sending message:', error);
    showAlert('Error sending message. Please try again.', 'danger');
  })
  .finally(() => {
    // Remove loading state
    messageInput.removeAttribute('disabled');
    sendButton.innerHTML = '<i class="ti ti-send"></i>';
    sendButton.removeAttribute('disabled');
  });
}

/**
 * Handle typing status
 */
function handleTyping(e) {
  // Ignore if Enter key is pressed (that's handled by form submit)
  if (e.key === 'Enter' && !e.shiftKey) return;
  
  const now = new Date().getTime();
  
  // Throttle typing notifications to avoid excessive API calls
  if (!typingStatus || now - lastTypingTime > 3000) {
    typingStatus = true;
    lastTypingTime = now;
    updateTypingStatus(true);
  }
  
  // Clear the timeout and set a new one
  clearTimeout(typingTimer);
  typingTimer = setTimeout(function() {
    typingStatus = false;
    updateTypingStatus(false);
  }, USER_TYPING_TIMEOUT);
}

/**
 * Update typing status via AJAX
 */
function updateTypingStatus(isTyping) {
  if (!chatUserId || !csrfToken) return;
  
  const formData = new FormData();
  formData.append('operation', 'update_typing_status');
  formData.append('recipient_id', chatUserId);
  formData.append('is_typing', isTyping ? '1' : '0');
  formData.append('csrf_token', csrfToken);
  
  fetch('message_operations.php', {
    method: 'POST',
    body: formData
  })
  .catch(error => {
    console.error('Error updating typing status:', error);
  });
}

/**
 * Show typing indicator
 */
function showTypingIndicator() {
  if (!typingIndicator) return;
  
  typingIndicator.classList.remove('hidden');
  typingIndicator.classList.add('animate__animated', 'animate__fadeIn');
  
  // Scroll to bottom when typing indicator appears
  scrollToBottom();
}

/**
 * Hide typing indicator
 */
function hideTypingIndicator() {
  if (!typingIndicator) return;
  
  typingIndicator.classList.add('hidden');
  typingIndicator.classList.remove('animate__animated', 'animate__fadeIn');
}

/**
 * Mark messages as read
 */
function markMessagesAsRead() {
  if (!chatUserId || !csrfToken) return;
  
  const formData = new FormData();
  formData.append('operation', 'mark_messages_read');
  formData.append('sender_id', chatUserId);
  formData.append('csrf_token', csrfToken);
  
  fetch('message_operations.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.status === 'success') {
      // Update message status indicators
      updateMessageStatusUI();
    }
  })
  .catch(error => {
    console.error('Error marking messages as read:', error);
  });
}

/**
 * Update message status UI to show read receipts
 */
function updateMessageStatusUI() {
  const unreadMessages = document.querySelectorAll('.message-sent .message-status i.ti-check');
  unreadMessages.forEach(icon => {
    icon.classList.remove('ti-check');
    icon.classList.add('ti-checks', 'text-primary');
  });
}

/**
 * Get current date from UI
 */
function getCurrentDateFromUI() {
  const dateSeparators = document.querySelectorAll('.info-message');
  if (dateSeparators.length > 0) {
    const lastDateSeparator = dateSeparators[dateSeparators.length - 1];
    
    // Convert the date text to a date value
    const dateText = lastDateSeparator.textContent;
    const today = new Date();
    
    if (dateText === 'Today') {
      return today.toISOString().split('T')[0];
    } else if (dateText === 'Yesterday') {
      const yesterday = new Date(today);
      yesterday.setDate(yesterday.getDate() - 1);
      return yesterday.toISOString().split('T')[0];
    } else {
      // Try to parse the date from the format "Month Day, Year"
      const date = new Date(dateText);
      if (!isNaN(date.getTime())) {
        return date.toISOString().split('T')[0];
      }
    }
  }
  
  // Default to today if no date separators found
  return new Date().toISOString().split('T')[0];
}

/**
 * Scroll to bottom of message container
 */
function scrollToBottom() {
  if (!messageContainer) return;
  
  messageContainer.scrollTop = messageContainer.scrollHeight;
}

/**
 * Play notification sound
 */
function playNotificationSound() {
  const audioElement = document.getElementById('notificationSound');
  if (audioElement) {
    audioElement.play().catch(e => {
      // Auto-play might be blocked by browser policy
      console.log('Sound notification blocked:', e);
    });
  }
}

/**
 * Show alert message
 */
function showAlert(message, type = 'info') {
  const alertContainer = document.getElementById('alertContainer');
  if (!alertContainer) return;
  
  const alertElement = document.createElement('div');
  alertElement.className = `alert alert-${type} alert-dismissible fade show animate__animated animate__fadeInDown`;
  alertElement.innerHTML = `
    ${message}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  `;
  
  alertContainer.appendChild(alertElement);
  
  // Auto dismiss after 5 seconds
  setTimeout(() => {
    alertElement.classList.remove('animate__fadeInDown');
    alertElement.classList.add('animate__fadeOutUp');
    
    setTimeout(() => {
      alertElement.remove();
    }, 500);
  }, 5000);
}

/**
 * Initialize emoji picker
 */
function initEmojiPicker() {
  const emojiButton = document.getElementById('emojiButton');
  const emojiPicker = document.getElementById('emojiPicker');
  
  if (!emojiButton || !emojiPicker) return;
  
  // Toggle emoji picker
  emojiButton.addEventListener('click', function(e) {
    e.preventDefault();
    emojiPicker.classList.toggle('show');
  });
  
  // Handle emoji selection
  const emojis = emojiPicker.querySelectorAll('.emoji');
  emojis.forEach(emoji => {
    emoji.addEventListener('click', function() {
      const emojiChar = this.textContent;
      
      // Insert emoji at cursor position
      const cursorPosition = messageInput.selectionStart;
      const textBefore = messageInput.value.substring(0, cursorPosition);
      const textAfter = messageInput.value.substring(cursorPosition);
      
      messageInput.value = textBefore + emojiChar + textAfter;
      messageInput.focus();
      
      // Set cursor position after inserted emoji
      messageInput.selectionStart = cursorPosition + emojiChar.length;
      messageInput.selectionEnd = cursorPosition + emojiChar.length;
      
      // Hide emoji picker
      emojiPicker.classList.remove('show');
    });
  });
}

/**
 * Initialize file upload
 */
function initFileUpload() {
  const fileUploadBtn = document.getElementById('fileUploadBtn');
  const fileUpload = document.getElementById('fileUpload');
  const filePreview = document.getElementById('filePreview');
  
  if (!fileUploadBtn || !fileUpload || !filePreview) return;
  
  // Trigger file input when button is clicked
  fileUploadBtn.addEventListener('click', function(e) {
    e.preventDefault();
    fileUpload.click();
  });
  
  // Handle file selection
  fileUpload.addEventListener('change', function() {
    if (this.files.length === 0) {
      filePreview.innerHTML = '';
      filePreview.classList.add('hidden');
      return;
    }
    
    const file = this.files[0];
    const fileExt = file.name.split('.').pop().toLowerCase();
    
    // Clear previous preview
    filePreview.innerHTML = '';
    filePreview.classList.remove('hidden');
    
    // Create preview content
    const previewContent = document.createElement('div');
    previewContent.className = 'd-flex align-items-center p-2 bg-light rounded';
    
    // Icon based on file type
    const iconClass = getFileIconClass(fileExt);
    
    // Check if it's an image
    if (['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'].includes(fileExt)) {
      // Create image preview
      const reader = new FileReader();
      reader.onload = function(e) {
        previewContent.innerHTML = `
          <div class="position-relative">
            <img src="${e.target.result}" class="img-thumbnail" style="max-height: 100px;" alt="${file.name}">
            <button type="button" class="btn-close position-absolute top-0 end-0 bg-white rounded-circle" id="removeFileBtn"></button>
          </div>
          <div class="ms-2">
            <div class="fw-bold">${file.name}</div>
            <div class="text-muted small">${formatFileSize(file.size)}</div>
          </div>
        `;
        filePreview.appendChild(previewContent);
        
        // Add event listener to remove button
        document.getElementById('removeFileBtn').addEventListener('click', function() {
          fileUpload.value = '';
          filePreview.innerHTML = '';
          filePreview.classList.add('hidden');
        });
      };
      reader.readAsDataURL(file);
    } else {
      // Create generic file preview
      previewContent.innerHTML = `
        <div class="p-2">
          <i class="${iconClass} fs-4"></i>
        </div>
        <div class="flex-grow-1">
          <div class="fw-bold">${file.name}</div>
          <div class="text-muted small">${formatFileSize(file.size)}</div>
        </div>
        <button type="button" class="btn-close ms-2" id="removeFileBtn"></button>
      `;
      filePreview.appendChild(previewContent);
      
      // Add event listener to remove button
      document.getElementById('removeFileBtn').addEventListener('click', function() {
        fileUpload.value = '';
        filePreview.innerHTML = '';
        filePreview.classList.add('hidden');
      });
    }
  });
}

/**
 * Open image viewer for full-size image viewing
 */
function openImageViewer(imageSrc) {
  // Create modal container
  const modal = document.createElement('div');
  modal.className = 'modal fade';
  modal.id = 'imageViewerModal';
  modal.tabIndex = '-1';
  modal.setAttribute('aria-hidden', 'true');
  
  modal.innerHTML = `
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center p-0">
          <img src="${imageSrc}" class="img-fluid" alt="Full size image">
        </div>
      </div>
    </div>
  `;
  
  // Add to document
  document.body.appendChild(modal);
  
  // Initialize and show modal
  const modalInstance = new bootstrap.Modal(modal);
  modalInstance.show();
  
  // Remove from DOM after hiding
  modal.addEventListener('hidden.bs.modal', function() {
    modal.remove();
  });
}

/**
 * Delete message functionality
 */
function deleteMessage(messageId) {
  if (!confirm('Are you sure you want to delete this message? This cannot be undone.')) return;
  
  if (!messageId || !csrfToken) return;
  
  const formData = new FormData();
  formData.append('operation', 'delete_message');
  formData.append('message_id', messageId);
  formData.append('csrf_token', csrfToken);
  
  fetch('message_operations.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.status === 'success') {
      // Remove message from UI
      const messageElement = document.querySelector(`.message-bubble[data-message-id="${messageId}"]`);
      if (messageElement) {
        messageElement.classList.add('animate__animated', 'animate__fadeOut');
        setTimeout(() => {
          messageElement.remove();
        }, 500);
      }
      
      showAlert('Message deleted successfully', 'success');
    } else {
      showAlert('Error deleting message: ' + data.message, 'danger');
    }
  })
  .catch(error => {
    console.error('Error deleting message:', error);
    showAlert('Error deleting message. Please try again.', 'danger');
  });
}

/**
 * Context menu for messages (right-click)
 */
function initMessageContextMenu() {
  // Add event listeners to all message bubbles
  document.addEventListener('contextmenu', function(e) {
    const messageBubble = e.target.closest('.message-sent');
    if (messageBubble) {
      e.preventDefault();
      
      const messageId = messageBubble.getAttribute('data-message-id');
      if (!messageId) return;
      
      // Remove any existing context menus
      const existingMenu = document.getElementById('contextMenu');
      if (existingMenu) {
        existingMenu.remove();
      }
      
      // Create context menu
      const contextMenu = document.createElement('div');
      contextMenu.id = 'contextMenu';
      contextMenu.className = 'context-menu';
      contextMenu.style.position = 'absolute';
      contextMenu.style.left = `${e.pageX}px`;
      contextMenu.style.top = `${e.pageY}px`;
      contextMenu.style.zIndex = '1000';
      contextMenu.style.background = '#fff';
      contextMenu.style.boxShadow = '0 2px 10px rgba(0,0,0,0.2)';
      contextMenu.style.borderRadius = '4px';
      contextMenu.style.padding = '8px 0';
      
      contextMenu.innerHTML = `
        <div class="context-menu-item" onclick="copyMessageText(${messageId})">
          <i class="ti ti-copy"></i> Copy
        </div>
        <div class="context-menu-item" onclick="deleteMessage(${messageId})">
          <i class="ti ti-trash"></i> Delete
        </div>
      `;
      
      document.body.appendChild(contextMenu);
      
      // Close menu when clicking outside
      document.addEventListener('click', function closeMenu() {
        contextMenu.remove();
        document.removeEventListener('click', closeMenu);
      });
    }
  });
}

/**
 * Copy message text to clipboard
 */
function copyMessageText(messageId) {
  const messageElement = document.querySelector(`.message-bubble[data-message-id="${messageId}"] .message-text`);
  if (!messageElement) return;
  
  const textToCopy = messageElement.textContent;
  
  navigator.clipboard.writeText(textToCopy)
    .then(() => {
      showAlert('Message copied to clipboard', 'success');
    })
    .catch(err => {
      console.error('Failed to copy text: ', err);
      showAlert('Failed to copy message', 'danger');
    });
}

// Initialize context menu for messages
initMessageContextMenu();