

function myFunction() {
new Chart(document.getElementById("myChart"), {
  type: 'line',
  data: {
    labels: [1500,1600,1700,1750,1800,1850,1900,1950,1999,2050],
    datasets: [{ 
        data: [555,200,300,450,700,300,290,600,1000,1200],
        borderColor: "#fff",
        fill: true
      },  
    ]
  },
  options: {
    plugins: {
        legend: {
            display: false,
         } },
    title: {
      display: false,
      text: 'World population per region (in millions)'
    },
       scales: {

            x: {
               grid: {
                  display: false
               },
               ticks: {
            display: false
        }
            },
            y: {
               grid: {
                  display: false
               },
               ticks: {
            display: false
        }
            }
       }
    
  }
});
}