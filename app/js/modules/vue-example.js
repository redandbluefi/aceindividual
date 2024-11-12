/**
 * JavaScript for custom block: VueExample
 *
 * - Initialize JS inside initBlockExample function
 * - Update document.querySelector() to match your custom block's CSS class
 * - Update your ACF Block's name to: render_block_preview/type=add_block_name_here
 */
import axios from 'axios/dist/axios';
import Vue from 'vue/dist/vue.esm-browser.prod.js';
/**
 * Pagination functions have been imported
 */
import changePage, {
  hideThis,
  scrollToTop,
  setPageArrow,
} from './vue-modules/pagination.js';

function initBlockExample() {
  // Init JS here

  const app = new Vue({
    el: '#vue--example',
    filters: {},

    data() {
      return {
        data: null,
        isLoading: false,
        page: 1,
        lang: window?.current_lang?.language,
        totalPages: null,
        dotsLeft: true,
        dotsRight: true,
      };
    },
    mounted() {
      this.fetchPosts(false);
    },

    methods: {
      scrollToTop,
      changePage,
      setPageArrow,
      hideThis,
      /**
       * Fetch posts from WP REST API
       * Change get parameters endpoint to match your needs
       * The _fields parameter fetches only the fields you need for better performance (https://developer.wordpress.org/rest-api/using-the-rest-api/global-parameters/#_fields)
       * ACF fileds are present in the rest api fith featured image url, if you need to extend rest api use file /inc/includes/restroute.php
       * The lang parameter fetches posts in the current language (https://wpml.org/documentation/support/language-configuration-files/#language-configuration-files)
       * The page parameter fetches posts in the current page
       *
       */

      fetchPosts() {
        this.isLoading = true;
        this.isEmpty = false;
        axios
          .get('/wp-json/wp/v2/Example', {
            params: {
              _fields: 'title,link,excerpt,acf,featured_image',
              lang: this.lang,
              page: this.page,
            },
          })
          .then((response) => {
            this.totalPages = +response.headers['x-wp-totalpages'];
            if (response.data === '') {
              this.isEmpty = true;
            }
            if (this.page !== 1) {
              this.data = this.data.concat(response.data);
            } else {
              this.data = response.data;
            }

            this.isLoading = false;
          })
          .catch((e) => e);
      },
    },
  });
  return app;
}
if (document.querySelector('#vue--example')) {
  // FRONT-END
  initBlockExample();
}
