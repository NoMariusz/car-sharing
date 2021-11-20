<script>
    import { API_PATH, RESERVATION_STATUSES } from "../../constants";

    export let reservations;
    export let loadAll;

    const cancelReservation = async (item) => {
        const res = await fetch(
            `${API_PATH}public/cancelReservation.php?reservation_id=${item.id}`
        );
        const d = await res.json();
        if (!d.success) alert(d.msg);
        loadAll();
    };

    const endReservation = async (item) => {
        const res = await fetch(
            `${API_PATH}public/endReservation.php?reservation_id=${item.id}`
        );
        const d = await res.json();
        if (!d.success) alert(d.msg);
        loadAll();
    };

    let qrElementRef = null;
    let qrCode = null;
    const showQr = (item) => {
        qrCode = new QRCode(qrElementRef, {
            text: JSON.stringify({
                reservation_id: item.id,
                car_id: item.car_id,
            }),
            correctLevel: QRCode.CorrectLevel.H,
        });
    };

    const cancelShowQr = () => {
        qrCode.clear();
        qrCode = null;
        // because qrCode.clear() does not clear html nodes
        qrElementRef.innerHTML = "";
    };
</script>

<div
    class={`fixed w-full top-0 left-0 bg-gray-300 h-full bg-opacity-60 ${
        qrCode ? "" : "hidden"
    }`}
    on:click={cancelShowQr}
>
    <script
        src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <div
        class="lg:w-2/3 md:w-1/1 mx-auto border-gray-200 border p-4 m-10 rounded-lg bg-white"
        on:click={(e) => e.stopPropagation()}
    >
        <div
            class="h-full flex items-center border-gray-200 border p-4 rounded-lg"
        >
            <div bind:this={qrElementRef} class="mx-auto" />
        </div>
    </div>
</div>

<div class="flex flex-wrap -m-2 lg:w-2/3 md:w-1/1 mx-auto mt-4">
    <p class="text-3xl text-primary-dark text-center p-2 w-full">
        Your reservations:
    </p>
    {#each reservations as item}
        <div class="p-1 w-full">
            <div
                class="h-full flex items-center border-gray-200 border p-4 rounded-lg"
            >
                <div
                    class="flex-grow flex flex-row justify-center items-center flex-wrap"
                />
                <h2 class="text-gray-900 title-font font-medium pb-1 flex-1">
                    {item.mark}
                    {item.model}
                </h2>
                <div
                    class="flex-grow flex flex-row justify-center flex-wrap flex-auto"
                >
                    <div class="flex flex-col p-1 border-r-2">
                        <p class="text-gray-500">Year: {item.year}</p>
                        <div class="flex justify-center items-center">
                            <div
                                class="w-5 h-5 shadow-md rounded-full mr-2"
                                style={`background-color: ${item.color}`}
                            />
                            <p class="text-gray-500">
                                Color: {item.color}
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-col p-1 flex-wrap">
                        <p class="text-gray-500">
                            Status: {item.status}
                        </p>
                        <div class="flex flex-row">
                            <p class="text-gray-500">Reservation time:</p>
                            <div class="flex flex-col">
                                <p class="text-gray-400">
                                    {item.start_date}
                                </p>
                                <p class="text-gray-400">
                                    {item.end_date}
                                </p>
                            </div>
                        </div>
                        {#if item.reservation_status_id == RESERVATION_STATUSES.Ended}
                            <div class="flex flex-row">
                                <p class="text-gray-500">Return car date:</p>
                                <p class="text-gray-400">
                                    {item.return_date}
                                </p>
                            </div>
                        {/if}
                    </div>
                </div>
                <div class="flex-1">
                    {#if item.reservation_status_id == RESERVATION_STATUSES.Pending}
                        <button
                            on:click={() => cancelReservation(item)}
                            class="flex-1 p-1 m-1 text-accent rounded"
                            >Cancel Reservation</button
                        >
                    {/if}
                    {#if item.reservation_status_id == RESERVATION_STATUSES.Active}
                        <button
                            on:click={() => endReservation(item)}
                            class="flex-1 p-1 m-1 text-primary-dark rounded"
                            >Return car</button
                        >
                        <button
                            on:click={() => showQr(item)}
                            class="flex-1 p-1 m-1 text-accent rounded"
                            >Access Code</button
                        >
                    {/if}
                </div>
            </div>
        </div>
    {/each}
</div>
