if (document.querySelector('[data-service-areas-popup]')) {
  import('./modules/service-areas-popup').then((m) => m.initServiceAreasPopup());
}

if (document.querySelector('[data-featured-vehicles]')) {
  import('./modules/featured-fetch').then((m) => m.initFeaturedVehicles());
}
