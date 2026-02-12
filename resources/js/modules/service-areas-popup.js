export function initServiceAreasPopup() {
  const trigger = document.querySelector('[data-service-areas-popup]');

  if (!trigger) {
    return;
  }

  trigger.addEventListener('click', () => {
    const target = document.getElementById('service-areas-modal');
    target?.classList.remove('hidden');
  });
}
