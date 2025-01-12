function markNotificationRead(notificationId) {
  fetch(`${window.appUrls.marcarNotificacionLeida}/${notificationId}`, {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({})
  })
  .then(response => response.json())
  .then(data => {
      document.querySelector('.notification-count').textContent = data.count;
      const notificationElement = document.querySelector(`[onclick="markNotificationRead('${notificationId}')"]`);
      if (notificationElement) {
          notificationElement.classList.remove('notification-unread');
          notificationElement.classList.add('notification-read');
      }
  })
  .catch(error => {
      console.log('Error', error);
  });
}