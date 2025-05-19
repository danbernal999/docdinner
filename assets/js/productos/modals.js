document.querySelectorAll('[data-modal-toggle]').forEach(btn => {
    btn.addEventListener('click', () => {
      const modalId = btn.getAttribute('data-modal-toggle');
      const modal = document.getElementById(modalId);
      modal.classList.toggle('hidden');
    });
  });

