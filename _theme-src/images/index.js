/* ===========================
  IMAGES
============================= */
const imagesIndex = {
  bg: require('./bg.png'),
  logoTwitter: require('./logos/Twitter_Logo_Blue.png'),
  logoFacebook: require('./logos/f_logo_RGB-Blue_58.png'),
  logo: require('./logos/logo-serif.png'),
  logoWhite: require('./logos/logo-serif-white.png'),
  loadingSpinner: require('./loading-spinner.png'),
  icons: {
    envelope: require('./icons/icon-envelope.svg'),
    chevronLeft: require('./icons/chevron-left.svg'),
    chevronRight: require('./icons/chevron-right.svg'),
  },
  // frontPage: require('../templates/front-page/front-page-images/index'),
};


global.images = imagesIndex; 
module.exports = imagesIndex;