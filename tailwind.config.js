/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
      './devise/Display/*.{html,js,php}',
      './devise/Display/auth/*.{html,js,php}',
  ],
  darkMode: 'class',
  theme: {
      extend: {
        colors: {
          'purple-xel': '#4e598c',
          'white-xel': '#ffffff',
          'orange-xel': '#f9c784',
        }
      },

      fontFamily: {
        'body': [
      'Roboto', 
      'ui-sans-serif', 
      'system-ui', 
      '-apple-system', 
      'system-ui', 
      'Segoe UI', 
      'Roboto', 
      'Helvetica Neue', 
      'Arial', 
      'Noto Sans', 
      'sans-serif', 
      'Apple Color Emoji', 
      'Segoe UI Emoji', 
      'Segoe UI Symbol', 
      'Noto Color Emoji'
    ],
        'sans': [
      'Roboto', 
      'ui-sans-serif', 
      'system-ui', 
      '-apple-system', 
      'system-ui', 
      'Segoe UI', 
      'Roboto', 
      'Helvetica Neue', 
      'Arial', 
      'Noto Sans', 
      'sans-serif', 
      'Apple Color Emoji', 
      'Segoe UI Emoji', 
      'Segoe UI Symbol', 
      'Noto Color Emoji'
    ]
      }
    },
  plugins: [
      require('@tailwindcss/forms'),
      require('@tailwindcss/typography'),
  ],
}

