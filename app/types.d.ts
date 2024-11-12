/* eslint-disable @typescript-eslint/no-explicit-any */

declare global {
  interface Window {
    restCall: {
      rest_url: string;
      nonce: string;
      theme_url: string;
      isLoggedIn: string;
      user_id: string;
      subscriptionType: string;
    };
    eterniaProperties: any;
    current_lang: {
      language: string
    };
    eternia: {
      lightbox?: {
        coreImagesEnableLightbox?: any;
        initLightbox?: any;
      };
      properties:{
        external_link_svg: string
        nonce: string
        rest_url: string
        root_url: string
      }
    }
  }
}

export { };
