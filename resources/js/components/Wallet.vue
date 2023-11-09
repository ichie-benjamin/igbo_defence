
<template>
    <form>

        <h2>Hello</h2>

        <div>
        <label for="walletSelect" class="block text-sm font-medium text-gray-700">Select a Wallet</label>
        <select v-model="selectedWallet" id="walletSelect" name="walletSelect" class="mt-1 block w-full p-2 border-gray-300 rounded-md focus:outline-none focus:border-indigo-500">
            <option v-for="(wallet, index) in wallets" :key="index" :value="wallet">
                {{ wallet.title }}
            </option>
        </select>

        <div v-if="selectedWallet">
            <p class="mt-2 text-sm text-gray-500">Selected Wallet: {{ selectedWallet.title }}</p>
        </div>
        </div>

    </form>
</template>


<script>

export default {
    props: {
        wallets: Object,
    },
    data() {
        return {
            selectedWallet : null
        }
    }
}

</script>


<style scoped>

</style>
