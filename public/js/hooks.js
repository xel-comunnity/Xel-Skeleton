import config from "../js/config.js";

// csrf-token.js
export async function fetchCsrfToken() {
  try {
    const response = await fetch(config.tokenGenerator);
    const data = await response.json();
    return data['X-CSRF-Token'];
  } catch (error) {
    console.error('Error fetching CSRF token:', error);
    throw error;
  }
}