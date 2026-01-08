// Laporan Charts Initialization

window.initLaporanCharts = function (chartData) {
    // Destroy existing charts if any (use Chart.getChart for safety)
    const canvasIds = [
        "trenPeminjamanChart",
        "bukuTerpopulerChart",
        "statusEksemplarChart",
        "kategoriChart",
    ];
    canvasIds.forEach((id) => {
        const existingChart = Chart.getChart(id);
        if (existingChart) {
            existingChart.destroy();
        }
    });

    // Chart 1: Tren Peminjaman (Line Chart)
    const trendCanvas = document.getElementById("trenPeminjamanChart");
    if (trendCanvas && chartData.trend.labels.length > 0) {
        const ctx = trendCanvas.getContext("2d");
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, "rgba(26, 188, 156, 0.4)");
        gradient.addColorStop(1, "rgba(26, 188, 156, 0)");

        window.trendChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: chartData.trend.labels,
                datasets: [
                    {
                        label: "Jumlah Peminjaman",
                        data: chartData.trend.data,
                        borderColor: "#1ABC9C",
                        backgroundColor: gradient,
                        borderWidth: 4,
                        tension: 0.4,
                        fill: true,
                        pointRadius: 6,
                        pointHoverRadius: 10,
                        pointBackgroundColor: "#fff",
                        pointBorderColor: "#1ABC9C",
                        pointBorderWidth: 3,
                        pointHoverBackgroundColor: "#1ABC9C",
                        pointHoverBorderColor: "#fff",
                        pointHoverBorderWidth: 3,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                interaction: {
                    intersect: false,
                    mode: "index",
                },
                plugins: {
                    legend: {
                        display: true,
                        position: "top",
                        align: "end",
                        labels: {
                            font: {
                                size: 13,
                                weight: "600",
                                family: "'Segoe UI', 'Helvetica Neue', Arial",
                            },
                            color: "#475569",
                            padding: 15,
                            usePointStyle: true,
                            pointStyle: "circle",
                        },
                    },
                    tooltip: {
                        enabled: true,
                        backgroundColor: "rgba(15, 23, 42, 0.95)",
                        titleColor: "#fff",
                        bodyColor: "#cbd5e1",
                        padding: 16,
                        borderColor: "#1ABC9C",
                        borderWidth: 2,
                        cornerRadius: 12,
                        titleFont: { size: 14, weight: "bold" },
                        bodyFont: { size: 13 },
                        displayColors: true,
                        boxPadding: 6,
                        callbacks: {
                            label: function (context) {
                                return (
                                    " Total: " +
                                    context.parsed.y +
                                    " peminjaman"
                                );
                            },
                        },
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            color: "#94a3b8",
                            font: { size: 12, weight: "500" },
                            padding: 10,
                        },
                        grid: {
                            color: "rgba(203, 213, 225, 0.25)",
                            drawBorder: false,
                            lineWidth: 1,
                        },
                        border: { display: false },
                    },
                    x: {
                        ticks: {
                            color: "#64748b",
                            font: { size: 12, weight: "600" },
                            padding: 10,
                        },
                        grid: {
                            display: false,
                            drawBorder: false,
                        },
                        border: { display: false },
                    },
                },
                animation: {
                    duration: 2000,
                    easing: "easeInOutQuart",
                },
            },
        });
    }

    // Chart 2: Buku Terpopuler (Horizontal Bar)
    const bukuCanvas = document.getElementById("bukuTerpopulerChart");

    if (bukuCanvas && chartData.buku.labels.length > 0) {
        const ctx = bukuCanvas.getContext("2d");

        window.bukuChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: chartData.buku.labels,
                datasets: [
                    {
                        label: "Total Pinjam",
                        data: chartData.buku.data,
                        backgroundColor: function (context) {
                            const chart = context.chart;
                            const { ctx, chartArea } = chart;
                            if (!chartArea) return "#1ABC9C";

                            const gradient = ctx.createLinearGradient(
                                chartArea.left,
                                0,
                                chartArea.right,
                                0
                            );
                            gradient.addColorStop(0, "rgba(26, 188, 156, 0.9)");
                            gradient.addColorStop(1, "rgba(22, 160, 133, 0.6)");
                            return gradient;
                        },
                        borderColor: "transparent",
                        borderWidth: 0,
                        borderRadius: 10,
                        borderSkipped: false,
                        barThickness: 20,
                        hoverBackgroundColor: "rgba(26, 188, 156, 1)",
                    },
                ],
            },
            options: {
                indexAxis: "y",
                responsive: true,
                maintainAspectRatio: true,
                layout: {
                    padding: { right: 20 },
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        enabled: true,
                        backgroundColor: "rgba(15, 23, 42, 0.95)",
                        padding: 16,
                        borderColor: "#1ABC9C",
                        borderWidth: 2,
                        cornerRadius: 12,
                        titleFont: { size: 13, weight: "bold" },
                        bodyFont: { size: 12 },
                        displayColors: false,
                        callbacks: {
                            title: function (context) {
                                return context[0].label;
                            },
                            label: function (context) {
                                return (
                                    "Total: " +
                                    context.parsed.x +
                                    " kali dipinjam"
                                );
                            },
                        },
                    },
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            color: "#94a3b8",
                            font: { size: 11, weight: "500" },
                            padding: 8,
                        },
                        grid: {
                            color: "rgba(203, 213, 225, 0.25)",
                            drawBorder: false,
                        },
                        border: { display: false },
                    },
                    y: {
                        ticks: {
                            color: "#475569",
                            font: { size: 11, weight: "600" },
                            padding: 12,
                        },
                        grid: {
                            display: false,
                            drawBorder: false,
                        },
                        border: { display: false },
                    },
                },
                animation: {
                    duration: 1800,
                    easing: "easeOutQuart",
                },
            },
        });
    }

    // Chart 3: Status Eksemplar (Doughnut)
    const statusCanvas = document.getElementById("statusEksemplarChart");
    if (statusCanvas && chartData.status.labels.length > 0) {
        window.statusChart = new Chart(statusCanvas.getContext("2d"), {
            type: "doughnut",
            data: {
                labels: chartData.status.labels,
                datasets: [
                    {
                        data: chartData.status.data,
                        backgroundColor: [
                            "rgba(26, 188, 156, 0.85)",
                            "rgba(245, 158, 11, 0.85)",
                            "rgba(239, 68, 68, 0.85)",
                            "rgba(148, 163, 184, 0.85)",
                        ],
                        borderColor: "#fff",
                        borderWidth: 4,
                        hoverOffset: 15,
                        hoverBorderWidth: 5,
                        hoverBorderColor: "#fff",
                        spacing: 2,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                cutout: "65%",
                plugins: {
                    legend: {
                        position: "bottom",
                        labels: {
                            font: {
                                size: 12,
                                weight: "600",
                                family: "'Segoe UI', 'Helvetica Neue', Arial",
                            },
                            color: "#475569",
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: "circle",
                            boxWidth: 12,
                            boxHeight: 12,
                        },
                    },
                    tooltip: {
                        enabled: true,
                        backgroundColor: "rgba(15, 23, 42, 0.95)",
                        padding: 16,
                        borderColor: "#1ABC9C",
                        borderWidth: 2,
                        cornerRadius: 12,
                        titleFont: { size: 14, weight: "bold" },
                        bodyFont: { size: 13 },
                        displayColors: true,
                        boxPadding: 8,
                        callbacks: {
                            label: function (context) {
                                const label = context.label || "";
                                const value = context.parsed || 0;
                                const total = context.dataset.data.reduce(
                                    (a, b) => a + b,
                                    0
                                );
                                const percentage = (
                                    (value / total) *
                                    100
                                ).toFixed(1);
                                return (
                                    " " +
                                    label +
                                    ": " +
                                    value +
                                    " (" +
                                    percentage +
                                    "%)"
                                );
                            },
                        },
                    },
                },
                animation: {
                    animateRotate: true,
                    animateScale: true,
                    duration: 2000,
                    easing: "easeInOutQuart",
                },
            },
        });
    }

    // Chart 4: Kategori (Pie)
    const kategoriCanvas = document.getElementById("kategoriChart");
    if (kategoriCanvas && chartData.kategori.labels.length > 0) {
        window.kategoriChart = new Chart(kategoriCanvas.getContext("2d"), {
            type: "pie",
            data: {
                labels: chartData.kategori.labels,
                datasets: [
                    {
                        data: chartData.kategori.data,
                        backgroundColor: [
                            "rgba(26, 188, 156, 0.9)",
                            "rgba(59, 130, 246, 0.9)",
                            "rgba(245, 158, 11, 0.9)",
                            "rgba(139, 92, 246, 0.9)",
                            "rgba(236, 72, 153, 0.9)",
                            "rgba(34, 197, 94, 0.9)",
                            "rgba(239, 68, 68, 0.9)",
                            "rgba(99, 102, 241, 0.9)",
                            "rgba(251, 146, 60, 0.9)",
                            "rgba(148, 163, 184, 0.9)",
                        ],
                        borderWidth: 4,
                        borderColor: "#fff",
                        hoverOffset: 12,
                        hoverBorderWidth: 5,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: "right",
                        align: "center",
                        labels: {
                            font: {
                                size: 11,
                                weight: "600",
                                family: "'Segoe UI', 'Helvetica Neue', Arial",
                            },
                            color: "#475569",
                            padding: 12,
                            usePointStyle: true,
                            pointStyle: "circle",
                            boxWidth: 10,
                            boxHeight: 10,
                        },
                    },
                    tooltip: {
                        enabled: true,
                        backgroundColor: "rgba(15, 23, 42, 0.95)",
                        padding: 16,
                        borderColor: "#1ABC9C",
                        borderWidth: 2,
                        cornerRadius: 12,
                        titleFont: { size: 13, weight: "bold" },
                        bodyFont: { size: 12 },
                        displayColors: true,
                        boxPadding: 8,
                        callbacks: {
                            label: function (context) {
                                const label = context.label || "";
                                const value = context.parsed || 0;
                                const total = context.dataset.data.reduce(
                                    (a, b) => a + b,
                                    0
                                );
                                const percentage = (
                                    (value / total) *
                                    100
                                ).toFixed(1);
                                return (
                                    " " +
                                    label +
                                    ": " +
                                    value +
                                    " buku (" +
                                    percentage +
                                    "%)"
                                );
                            },
                        },
                    },
                },
                animation: {
                    animateRotate: true,
                    animateScale: true,
                    duration: 2000,
                    easing: "easeInOutQuart",
                },
            },
        });
    }
};
