<template>
    <div class="card bg-slate-800/50 hover:bg-stone-400 drop-shadow-lg">
        <div>
            <div class="flex flex-col mb-3">
                <strong class="card-name">{{ cardName.charAt(0).toUpperCase() + cardName.slice(1) }}</strong>
                <span class="card-type">Type: {{ cardType }}</span>
            </div>
        </div>
        <div class="card-info text-end">
            <p><strong class="label text-xl">Balance:</strong> {{ balance + " " + currencyType }}</p>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        cardName: {
            type: String,
            required: true
        },
        currencyType: {
            type: String,
            required: true
        },
        cardType: {
            type: String,
            required: true
        },
        balance: {
            type: Number,
            required: true
        }
    }
};
</script>

<style scoped>
.card {
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
    color: black;
}


.label {
    font-weight: bold;
}
</style>


