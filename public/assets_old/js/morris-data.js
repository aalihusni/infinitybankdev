$(function() {

    Morris.Donut({
        element: 'donut-example',
        data: [
            {label: "Download Sales", value: 12, color: "#e09f29"},
            {label: "In-Store Sales", value: 30, color: "#794991"},
            {label: "Mail-Order Sales", value: 20, color:"#689837"}
        ]
    });

});
