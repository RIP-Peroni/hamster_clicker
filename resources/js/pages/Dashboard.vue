<script setup>
import { ref } from 'vue'
import { Head, router } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'

const props = defineProps({
    stats: {
        type: Object,
        default: () => ({ total: 0, today: 0, last7Days: [] })
    }
})

const stats = ref(props.stats)

const handleClick = async () => {
    router.post('/api/clicks', {}, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            fetch('/api/stats')
                .then(response => response.json())
                .then(newStats => {
                    stats.value = newStats
                })
                .catch(error => console.error('Error fetching stats:', error))
        },
        onError: (errors) => {
            console.error('Error saving click:', errors)
        }
    })
}

const downloadPdf = () => {
    window.open('/pdf/download', '_blank')
}
</script>

<template>
    <Head title="Hamster Clicker" />
    
    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                🐹 Hamster Clicker
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <!-- Hamster Image -->
                        <div class="text-center mb-8">
                            <img 
                                src="https://cdn-icons-png.flaticon.com/512/2012/2012698.png"
                                alt="Hamster"
                                class="w-48 h-48 mx-auto cursor-pointer hover:scale-110 transition-transform duration-200"
                                @click="handleClick"
                            />
                            <p class="mt-2 text-gray-600">Click the hamster!</p>
                        </div>

                        <!-- Stats -->
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-semibold mb-4">Your Statistics</h3>
                            
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div class="bg-blue-50 p-4 rounded-lg">
                                    <p class="text-sm text-gray-600">Total Clicks</p>
                                    <p class="text-3xl font-bold text-blue-600">{{ stats.total }}</p>
                                </div>
                                <div class="bg-green-50 p-4 rounded-lg">
                                    <p class="text-sm text-gray-600">Today</p>
                                    <p class="text-3xl font-bold text-green-600">{{ stats.today }}</p>
                                </div>
                            </div>

                            <h4 class="font-medium mb-2">Last 7 Days</h4>
                            <div class="overflow-x-auto">
                                <table class="min-w-full border">
                                    <thead>
                                        <tr class="bg-gray-100">
                                            <th class="px-4 py-2 border">Date</th>
                                            <th class="px-4 py-2 border">Clicks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="day in stats.last7Days" :key="day.date">
                                            <td class="px-4 py-2 border">{{ day.date }}</td>
                                            <td class="px-4 py-2 border text-center">{{ day.count }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-6">
                                <button 
                                    @click="downloadPdf"
                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors"
                                >
                                    Download PDF Report 📄
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>