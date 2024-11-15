let invoices = [
    {
      customer: {
        name: "Coca Cola",
        type: "B2B"
      },
      paid: false,
      items: [
        { subtotal: 1234.44, description: 'asdfg' },
        { subtotal: 5678.88, description: 'qwerty' }
      ]
    },
    {
      customer: {
        name: "Juan Perez",
        type: "B2C"
      },
      paid: false,
      items: [
        { subtotal: 5556.54, description: 'asdfg' },
        { subtotal: 9632.21, description: 'qwerty' }
      ]
    },
    {
      customer: {
        name: "John Smith",
        type: "B2C"
      },
      paid: true,
      items: [
        { subtotal: 1234.44, description: 'asdfg' },
        { subtotal: 5678.88, description: 'qwerty' }
      ]
    },
    {
      customer: {
        name: "Esteban Quito",
        type: "B2C"
      },
      paid: false,
      items: [
        { subtotal: 895.7, description: 'asdfg' },
        { subtotal: 8542.34, description: 'qwerty' },
        { subtotal: 9674.95, description: 'qwerty' }
      ]
    }
  ];

//Facturas no pagadas
let unpaidInvoices = invoices.filter(invoice => !invoice.paid);

//Calculo total adeudado por cliente
let totalByType = unpaidInvoices.reduce((acc, invoice) => {

    let total = invoice.items.reduce((sum, item) => sum + item.subtotal, 0);

    //Agrupo por tipo de cliente
    if (!acc[invoice.customer.type]) {
        acc[invoice.customer.type] = 0;
    }

    acc[invoice.customer.type] += total;
    return acc;
}, {});

//Redondeo de totales al final, porque me daba decimales largos
for (let type in totalByType) {
    totalByType[type] = parseFloat(totalByType[type].toFixed(2));
  }

console.log(totalByType); //Devuelve { B2B: 6913.32, B2C: 34301.74 }