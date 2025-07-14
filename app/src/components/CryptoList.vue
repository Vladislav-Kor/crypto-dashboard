<template>
    <div>
        <h2>Список криптовалют</h2>
        <div v-if="loading">Загрузка данных...</div>
        <div v-if="error" class="error">{{ error }}</div>
        <table v-if="cryptos.length" border="1" cellpadding="5">
            <thead>
                <tr>
                    <th>Символ</th>
                    <th>Название</th>
                    <th>Цена</th>
                    <th>Изменение за 24ч</th>
                    <th>Рыночная капитализация</th>
                    <th>Объем за 24ч</th>
                    <th>Последнее обновление</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="crypto in cryptos" :key="crypto.id">
                    <td>{{ crypto.symbol }}</td>
                    <td>{{ crypto.name }}</td>
                    <td>{{ crypto.price.toFixed(8) }}</td>
                    <td :class="{ positive: crypto.price_change_24h >= 0, negative: crypto.price_change_24h < 0 }">
                        {{ crypto.price_change_24h ? crypto.price_change_24h.toFixed(4) : '—' }}
                    </td>
                    <td>{{ crypto.market_cap ? crypto.market_cap.toLocaleString() : '—' }}</td>
                    <td>{{ crypto.volume_24h ? crypto.volume_24h.toLocaleString() : '—' }}</td>
                    <td>{{ crypto.last_updated ? new Date(crypto.last_updated).toLocaleString() : '—' }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'CryptoList',
    data() {
        return {
            cryptos: [],
            loading: false,
            error: null,
        };
    },
    methods: {
        fetchCryptos() {
            this.loading = true;
            axios.get('http://localhost:8080/crypto-currency')
                .then(response => {
                    this.cryptos = response.data.items;
                })
                .catch(() => {
                    this.error = 'Ошибка загрузки данных с сервера';
                })
                .finally(() => {
                    this.loading = false;
                });
        }
    },
    mounted() {
        this.fetchCryptos();
    }
};
</script>

<style scoped>
.positive {
    color: green;
}

.negative {
    color: red;
}

.error {
    color: red;
    margin: 10px 0;
}
</style>
