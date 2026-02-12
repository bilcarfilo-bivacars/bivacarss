export async function initFeaturedVehicles() {
  const root = document.querySelector('[data-featured-vehicles]');

  if (!root) {
    return;
  }

  const response = await fetch('/api/featured-vehicles', {
    headers: { Accept: 'application/json' },
  });

  if (!response.ok) {
    return;
  }

  const vehicles = await response.json();
  root.innerHTML = vehicles
    .map((vehicle) => `<li>${vehicle.brand} ${vehicle.model}</li>`)
    .join('');
}
