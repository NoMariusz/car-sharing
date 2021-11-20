<script>
    import { API_PATH } from "../../constants";

    const startAccelerator = async () => {
        aloneQuery("startTimeAccelerator.php");
    };

    const stopAccelerator = async () => {
        aloneQuery("stopTimeAccelerator.php");
    };

    const aloneQuery = async (name) => {
        const res = await fetch(`${API_PATH}public/${name}`);
        const d = await res.json();
        if (!d.success) {
            alert(d.msg);
        }
    };
</script>

<div class="p-1 md:w-2/3 w-full mx-auto">
    <div
        class="h-full flex flex-col items-center border-gray-200 border p-4 rounded-lg"
    >
        <p class="text-2xl text-primary-dark">Time accelerator</p>
        <div
            class="flex-grow flex flex-row justify-center items-center flex-wrap"
        >
            <button class="act-btn" on:click={startAccelerator}>Start</button>
            <button class="act-btn" on:click={stopAccelerator}>Stop</button>
        </div>
    </div>
</div>

<style>
    .act-btn {
        @apply p-1 m-1 flex-1 text-accent;
    }
</style>
