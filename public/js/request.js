import { fetchCsrfToken } from '../js/hooks.js';

// ? Request with csrf Token
export async function makeRequestWithCsrfToken(url, options = {}) {
    try {
      const csrfToken = await fetchCsrfToken();
      const headers = {
        'X-CSRF-Token': csrfToken,
        ...options.headers
      };
  
      const response = await fetch(url, {
        ...options,
        headers
      });
  
      return response;
    } catch (error) {
      console.error('Error:', error);
      throw error;
    }
}


// ? normal request
export async function makeRequest(url, options = {}) {
    try {
        const response = await fetch(url, options);
        return response;
    } catch (error) {
        console.error('Error:', error);
        throw error;
    }
}

