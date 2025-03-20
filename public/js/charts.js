




document.addEventListener('DOMContentLoaded', function() {


fetch('http://localhost:8000/facturas')
  .then(response => response.json())
  .then(data => {


    
    data.forEach(element => {
         res = element.Respuestas;
         tmp = element.Tiempo;
         snd = element.Enviadas;
         rcv = element.Recibidas;
         empresa = element.Empresa;
     
    });
    
   let span = document.getElementById("name");
    if (span) {
       span.textContent = empresa; 
    }
   
    const time = []
    tmp.forEach(index=> {
        let minsData = index;

        time.push(minsData);
    });


  const response = []
    res.forEach(i => {
        let responseData = i;

        response.push(responseData);

    });

    
    const send = []
    snd.forEach(indice =>{
        let sendData = indice;

        send.push(sendData)

    });


    const receive = []
    rcv.forEach(ind =>{
        let receiveData = ind;

        receive.push(receiveData)
  
    });

  
   


    new Chart("transacPerMinute", {
      type: "line",
      data: {
        labels: time,
        datasets: [
            {
          label: "Respuestas MH",
          data: response,
          borderColor: "rgba(61,141,189, 0.8)",
          backgroundColor: "rgba(61,141,189, 0.2)",
          borderWidth: 5,
          pointBackgroundColor: [
            '#354abb',
          
            ],
          pointBorderColor:[
            '#354abb',
          ],
          tension: .5,
          
        },
        {
            label: "Recibidas",
            data: receive,
            borderColor: 'rgba(0,255,91, 0.8)',
            backgroundColor:'rgba(0,255,91, 0.2)',
            borderWidth: 5,
            pointBackgroundColor: [
                'rgb(0,167,91)',
              
                ],
              pointBorderColor:[
                'rgb(0,167,91)',
              ],
              tension: .5,
            
          },
          {
            label: "Enviadas",
            data: send,
            borderColor: "rgba(243,157,19, 0.8)",
            backgroundColor: "rgba(243,157,19, 0.2)",
            borderWidth: 5,
            pointBackgroundColor: [
                'rgb(255,107,19)',
              
                ],
              pointBorderColor:[
                'rgb(253,107,19)',
              ],
              tension: .5,
          }
    ],
  
      },
      options: {
     
        scales: {
          x: {
            title: {
              display: true,
              text: 'Minutos',
              color: 'white'
            },
            grid:{
                display : true,
                color: "white",
                lineWidth: 0.5
            },
            ticks: {
                color: 'white' // Cambiar el color del texto en el eje Y a rojo
              }

          },
          y: {
            title: {
              display: true,
              text: 'Facturas',
              color: 'white'
            },
            grid:{
                display : true,
                color: "white",
                lineWidth: 0.5
            },
            ticks: {
                color: 'white' // Cambiar el color del texto en el eje Y a rojo
              }
            
          },
        },
        plugins: {
            legend: {
              position: 'bottom',
              labels: {
                color: 'white', // Cambia el color del texto de la leyenda a rojo
              }
            }
          }
        
      }
    });


    let totalSend = send.reduce(function(acc, curr) {
        return acc + curr;
    }, 0);
    
    let totalReceive = receive.reduce(function(acc, curr) {
        return acc + curr;
    }, 0);
    
    let totalResponse = response.reduce(function(acc, curr) {
        return acc + curr;
    }, 0);
    

    
    let totalGlobal = totalReceive + totalResponse + totalSend;
    
    let percentSend = (totalSend / totalGlobal) * 100;
    let percentReceive = (totalReceive / totalGlobal) * 100;
    let percentResponse = (totalResponse / totalGlobal) * 100;


    let percentReceiveParsed = percentReceive.toFixed(2);
    let percentSendParsed = percentSend.toFixed(2);
    let percentResponseParsed = percentResponse.toFixed(2);


    let p = percentReceiveParsed.toString()+'%';
    
    console.log(p);




    

    
    const percent = document.getElementById('transacPercent').getContext('2d');
    const state = [`Procesadas ${percentSendParsed}%`, `Observación ${percentReceiveParsed}% `, `Rechazadas ${percentResponseParsed}%`, "Example ", "Example 2"];
    const valueState = [totalSend, totalReceive, totalResponse, 15000, 10000];
    
    const percentGraphic = new Chart(percent, {
        type: 'doughnut',
        data: {
        labels: state,
          datasets: [{
            label: 'N° de facturas',
            data: valueState,
            backgroundColor: [
              'rgba(93, 173, 206,0.3)',
              'rgba(199, 0, 127, 0.3)',
              'rgba(173, 73, 206, 0.3)',
              'rgba(205, 205, 0, 0.3)',
              'rgba(0, 205, 0, 0.3)',
            ],
            borderColor: [
                'rgba(93, 173, 226,1)',
                'rgba(199, 0, 157, 1)',
                'rgba(193, 73, 226, 1)',
                'rgba(255, 255, 0, 1)',
                'rgba(10, 195, 0, 1)',
              ],
            borderWidth: 1.5,
       
          }],
         
         
        },
        options: {
            plugins: {
              legend: {
                position: 'bottom',
                labels: {
                  color: 'white', // Cambia el color del texto de la leyenda a rojo
                }
              }
            }
          }
        
      });
      
    
    







  });



//========================================================================
    const dailyAmount = document.getElementById('dailyAmount').getContext('2d');
    const days = ['Lunes', 'Martes', 'Martes', 'Miercoles', 'Jueves', 'Viernes','Sabado'];
    const amount = [3000, 4200, 5500, 2800, 3600,9000,7500 ];

    const dailyAmountGraphic = new Chart(dailyAmount, {
        type: 'bar',
        data: {
            labels: days,
            datasets: [{
                label: 'USD',
                data: amount,
                backgroundColor: [
                    'rgb(102,17,243)',
                    'rgb(254,193,6)',
                    'rgb(40,167,69)',
                    'rgb(221,53,68)',
                    'rgb(253,126,20)',
                    'rgb(61,140,188)',
                    'rgb(240,19,191)',
                ],
                borderWidth: 1.5
            }]
        },
        options: {
     
            scales: {
              x: {
                title: {
                  display: true,
                  text: 'Dias',
                  color: 'white'
                },
                grid:{
                    display : true,
                    color: "white",
                    lineWidth: 0.5
                },
                ticks: {
                    color: 'white' // Cambiar el color del texto en el eje Y a rojo
                  }
    
              },
              y: {
                title: {
                  display: true,
                  text: 'Valores',
                  color: 'white'
                },
                grid:{
                    display : true,
                    color: "white",
                    lineWidth: 0.5
                },
                ticks: {
                    color: 'white' // Cambiar el color del texto en el eje Y a rojo
                  }
                
              },
            },
            plugins: {
                legend: {
                  display: false,
                  position: 'top',
                  labels: {
                    color: 'white', // Cambia el color del texto de la leyenda a rojo
                  }
                }
              }
            
          }
    });
//========================================================================
const mhResponse = document.getElementById('mhResponse').getContext('2d');
const status = ['Observaciones', 'Firmadas'];
const statusValue = [200, 300];

const mhResponseGraphic = new Chart(mhResponse, {
    type: 'doughnut',
    data: {
        labels: status,
        datasets: [{
            label: 'Cantidad',
            data: statusValue,
            backgroundColor: [
                'rgb(202,40,92)',
                'rgb(0,167,91)',
            
            ],
            borderWidth: 1
        }]
    },
    options: {
        cutout: '70%',
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
//========================================================================
/* const percent = document.getElementById('transacPercent').getContext('2d');
const state = ['Enviadas', 'Rechazadas', 'Fallidas', 'Procesadas'];
const valueState = [10000, 1500, 1500, 7000];

const percentGraphic = new Chart(percent, {
  type: 'pie',
  data: {
    labels: state,
    datasets: [{
      label: 'N° de facturas',
      data: valueState,
      backgroundColor: [
        'rgba(199, 0, 57)',
        'rgba(93, 173, 226)',
        'rgba(199, 0, 157)',
        'rgba(193, 73, 226)',
      ],
      borderWidth: 1
    }]
  }
});
 */

 

// Datos de ejemplo



//============================================

const ctx5 = document.getElementById('myChart5').getContext('2d');
const data5 = {
    labels: ['A', 'B', 'C', 'D', 'E'],
    datasets: [{
        label: 'Valores',
        data: [10, 15, 7, 12, 8],
        backgroundColor: [
            'rgba(255, 99, 132, 0.5)',
            'rgba(54, 162, 235, 0.5)',
            'rgba(255, 206, 86, 0.5)',
            'rgba(75, 192, 192, 0.5)',
            'rgba(153, 102, 255, 0.5)',
        ],
        borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)'
        ],
        borderWidth: 1
    }]
};

const config5 = {
    type: 'polarArea',
    data: data5,
    options: {}
};

const myChart5 = new Chart(ctx5, config5);

//================================

const ctx6 = document.getElementById('myChart6').getContext('2d');
const data6 = {
    labels: ['A', 'B', 'C', 'D', 'E'],
    datasets: [{
        label: 'Valores',
        data: [10, 15, 7, 12, 8],

        
        backgroundColor: 'rgba(54, 162, 235, 0.5)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1,
        pointBorderColor: 'rgba(54, 162, 235, 1)',
        pointBackgroundColor: '#fff',
        pointBorderWidth: 1.5,
        pointRadius: 4
    }],
    
};

const config6 = {
    type: 'radar',
    data: data6,
    options: {
        elements: {
            line: {
                borderWidth: 3
            }
        }
    }
};

const myChart6 = new Chart(ctx6, config6);


//========================================================================
const ctx7 = document.getElementById('myChart7').getContext('2d');
const names7 = ['Fallos', 'Exitos'];
const values7 = [500, 2000];

const myChart7 = new Chart(ctx7, {
    type: 'pie',
    data: {
        labels: names7,
        datasets: [{
            label: 'a',
            data: values7,
            backgroundColor: [
                'rgba(199, 0, 57)',
                'rgba(93, 173, 226)',
          
            
            ],
          
            borderWidth: 1
        }]
    },
    
});

//========================================================================
const ctx8 = document.getElementById('myChart8').getContext('2d');
const names8 = ['Fallos', 'Exitos'];
const values8 = [500, 2000];

const myChart8 = new Chart(ctx8, {
    type: 'doughnut',
    data: {
        labels: names8,
        datasets: [{
            label: 'Cantidad',
            data: values8,
            backgroundColor: [
                'rgb(231, 76, 60)',
                'rgb(88, 214, 141 )',
            
            ],
            borderWidth: 1
        }]
    },
    options: {
        cutout: '70%',
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

//================================

const ctx9 = document.getElementById('myChart9').getContext('2d');
const data9 = {
    labels: ['A', 'B', 'C', 'D', 'E'],
    datasets: [{
        label: 'Valores',
        data: [10, 15, 7, 12, 8],

        
        backgroundColor: 'rgba(54, 162, 235, 0.5)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1,
        pointBorderColor: 'rgba(54, 162, 235, 1)',
        pointBackgroundColor: '#fff',
        pointBorderWidth: 1.5,
        pointRadius: 4
    }],
    
};

const config9 = {
    type: 'radar',
    data: data9,
    options: {
        elements: {
            line: {
                borderWidth: 3
            }
        }
    }
};

const myChart9 = new Chart(ctx9, config6);

//========================================================================
const ctx10 = document.getElementById('myChart10').getContext('2d');
    const names10 = ['Alice', 'Bob', 'Charlie', 'David', 'Eve'];
    const ages10 = [30, 42, 55, 28, 36];

    const myChart10 = new Chart(ctx10, {
        type: 'bar',
        data: {
            labels: names10,
            datasets: [{
                label: 'example',
                data: ages10,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(99, 255, 234, 0.8)',
                    'rgba(252, 252, 75, 0.8)',
                    'rgba(155, 75, 252, 0.8)',
                    'rgba(252, 75, 75, 0.8)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(99, 255, 234, 1)',
                    'rgba(252, 252, 75, 1)',
                    'rgba(155, 75, 252, 1)',
                    'rgba(252, 75, 75, 1)'
                ],
                borderWidth: 1.5
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });





    const content = document.getElementsByClassName("content");
   


    content.classList.add("p-0");   
    content.classList.add("m-0");



    

});
