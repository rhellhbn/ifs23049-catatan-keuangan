<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Statistik Keuangan') }}
            </h2>
            <a href="{{ route('transactions.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Chart 1: Pemasukan vs Pengeluaran per Bulan -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
              <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">📊 Pemasukan vs Pengeluaran (6 Bulan Terakhir)</h3>
                    <div id="monthlyChart"></div>
                </div>
            </div>

            <!-- Chart 2: Kategori Pengeluaran -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">💸 Pengeluaran per Kategori</h3>
                    <div id="expenseCategoryChart"></div>
                </div>
            </div>

            <!-- Chart 3: Kategori Pemasukan -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">💰 Pemasukan per Kategori</h3>
                    <div id="incomeCategoryChart"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Prepare data untuk monthly chart
        const monthlyData = @json($monthlyStats);
        
        // Organize data by month
        const months = [...new Set(monthlyData.map(item => item.month))].sort();
        const incomeData = [];
        const expenseData = [];

        months.forEach(month => {
            const income = monthlyData.find(item => item.month === month && item.type === 'income');
            const expense = monthlyData.find(item => item.month === month && item.type === 'expense');
            
            incomeData.push(income ? parseFloat(income.total) : 0);
            expenseData.push(expense ? parseFloat(expense.total) : 0);
        });

        // Monthly Chart
        const monthlyChartOptions = {
            series: [{
                name: 'Pemasukan',
                data: incomeData
            }, {
                name: 'Pengeluaran',
                data: expenseData
            }],
            chart: {
                type: 'bar',
                height: 350,
                toolbar: {
                    show: true
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: months.map(month => {
                    const [year, monthNum] = month.split('-');
                    const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                    return monthNames[parseInt(monthNum) - 1] + ' ' + year;
                }),
            },
            yaxis: {
                title: {
                    text: 'Jumlah (Rp)'
                },
                labels: {
                    formatter: function (value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "Rp " + val.toLocaleString('id-ID');
                    }
                }
            },
            colors: ['#10b981', '#ef4444']
        };

        const monthlyChart = new ApexCharts(document.querySelector("#monthlyChart"), monthlyChartOptions);
        monthlyChart.render();

        // Prepare data untuk category charts
        const categoryData = @json($categoryStats);
        
        // Expense Categories
        const expenseCategories = categoryData.filter(item => item.type === 'expense');
        const expenseCategoryLabels = expenseCategories.map(item => item.category);
        const expenseCategoryValues = expenseCategories.map(item => parseFloat(item.total));

        // Expense Category Chart (Pie)
        const expenseCategoryChartOptions = {
            series: expenseCategoryValues,
            chart: {
                type: 'donut',
                height: 350
            },
            labels: expenseCategoryLabels,
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }],
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "Rp " + val.toLocaleString('id-ID');
                    }
                }
            },
            legend: {
                position: 'bottom'
            },
            colors: ['#ef4444', '#f97316', '#f59e0b', '#eab308', '#84cc16', '#22c55e', '#10b981', '#14b8a6', '#06b6d4', '#0ea5e9']
        };

        const expenseCategoryChart = new ApexCharts(document.querySelector("#expenseCategoryChart"), expenseCategoryChartOptions);
        expenseCategoryChart.render();

        // Income Categories
        const incomeCategories = categoryData.filter(item => item.type === 'income');
        const incomeCategoryLabels = incomeCategories.map(item => item.category);
        const incomeCategoryValues = incomeCategories.map(item => parseFloat(item.total));

        // Income Category Chart (Pie)
        const incomeCategoryChartOptions = {
            series: incomeCategoryValues,
            chart: {
                type: 'pie',
                height: 350
            },
            labels: incomeCategoryLabels,
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }],
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "Rp " + val.toLocaleString('id-ID');
                    }
                }
            },
            legend: {
                position: 'bottom'
            },
            colors: ['#10b981', '#14b8a6', '#06b6d4', '#0ea5e9', '#3b82f6', '#6366f1', '#8b5cf6', '#a855f7', '#d946ef', '#ec4899']
        };

        const incomeCategoryChart = new ApexCharts(document.querySelector("#incomeCategoryChart"), incomeCategoryChartOptions);
        incomeCategoryChart.render();
    </script>
</x-app-layout>