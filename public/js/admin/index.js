const renderChart = (data, element, configs) => {
    new Chart(
        element,
        {
            type: configs.type,
            data: {
                labels: data.map(row => row[configs?.row_label]),
                datasets: [
                    {
                        label: configs?.label,
                        data: data.map(row => row[configs?.row_value]),
                        backgroundColor: configs?.bg,
                    }
                ],
            },
            options: {...configs.options}
        }
    );

}
