// Styles
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'
import colors from 'vuetify/lib/util/colors'

// Vuetify
import { createVuetify } from 'vuetify'

export default createVuetify({
  theme: {
    themes: {
      light: {
        dark: false,
        colors: {
          primary: colors.blue.darken3, // #E53935
          secondary: colors.grey.darken3, // #FFCDD2
        }
      },
    },
  },
  defaultTheme: 'light',
})
