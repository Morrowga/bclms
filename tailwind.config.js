/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
      "./src/**/*.vue",
      "./src/**/*.js",
    ],
    theme: {
      extend: {
          backgroundImage: {
              'bgimage': "url('/public/images/sample1.png')"
            },
            fontSize:{
              'c63':'63px !important',
              'h27':'27px !important',
              'h1':'67px !important',
              'h2':'52px !important',
              'h3':'38px !important',
              'h4':'28px !important',
              'h5':'22px !important',
              'body':'16px !important',
              'caption':'12px !important',
            },
            fontFamily:{
                'fredoka':['fredoka'],
                'worksans':['worksans']
              },
            colors:{
              'primary':'#001A8F !important',
              'secondary':'#FAB141 !important',
              'ccblue':'#5271FF !important',
              'cwhite':'#F9F8FF !important',
            }
      },
    },
    plugins: [],
  }









