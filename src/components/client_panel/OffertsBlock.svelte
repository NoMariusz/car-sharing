<script>
    import { API_PATH } from "../../constants";

    export let loadAll;

    export let offers;

    const getStatus = (item) => {
        return item.is_reserved
            ? "Not available"
            : item.reservations_count <= 0
            ? "Available"
            : "Pending requests";
    };

    let sortBy = { col: "id", ascending: true };

    const sortOffers = (column) => {
        if (sortBy.col == column) {
            sortBy.ascending = !sortBy.ascending;
        } else {
            sortBy.col = column;
            sortBy.ascending = true;
        }

        // Modifier to sorting function for ascending or descending
        let sortModifier = sortBy.ascending ? 1 : -1;

        let sort = (a, b) =>
            a[column] < b[column]
                ? -1 * sortModifier
                : a[column] > b[column]
                ? 1 * sortModifier
                : 0;

        offers = offers.sort(sort);
    };

    let filterObj = {};

    $: filteredList = offers.filter((offer) =>
        Object.keys(filterObj).every(
            (key) => offer[key] == filterObj[key] || !filterObj[key]
        )
    );

    $: getValuesForKey = (key) => ["", ...new Set(offers.map((e) => e[key]))];

    let selectedToReserve = null;
    const now = new Date().toLocaleString().replace(", ", "T");

    let reserveDates = {
        start: now,
        end: now,
    };

    const selectToReserve = (item) => {
        selectedToReserve = item;
    };

    const cancelSelectToReserve = () => {
        selectedToReserve = null;
    };

    const reserveCar = async () => {
        const sDate = reserveDates.start.replace("T", " ");
        const eDate = reserveDates.end.replace("T", " ");
        const res = await fetch(
            `${API_PATH}public/addReservation.php?car_id=${selectedToReserve.id}&start_date=${sDate}&end_date=${eDate}`
        );
        const d = await res.json();
        if (!d.success) alert(d.msg);
        cancelSelectToReserve();
        loadAll();
    };
</script>

{#if selectedToReserve}
    <div
        class="fixed w-full top-0 left-0 bg-gray-300 h-full"
        on:click={cancelSelectToReserve}
    >
        <div
            class="lg:w-2/3 md:w-1/1 mx-auto border-gray-200 border p-4 m-10 rounded-lg bg-white"
            on:click={(e) => e.stopPropagation()}
        >
            <div
                class="h-full flex items-center border-gray-200 border p-4 rounded-lg"
            >
                <div
                    class="flex-grow flex flex-row justify-center items-center flex-wrap"
                >
                    <h2
                        class="text-gray-900 title-font font-medium pb-1 flex-1"
                    >
                        {selectedToReserve.mark}
                        {selectedToReserve.model}
                    </h2>
                    <div
                        class="flex-grow flex flex-row justify-center flex-wrap flex-auto"
                    >
                        <div class="flex flex-col p-1 border-r-2">
                            <p class="text-gray-500">
                                Year: {selectedToReserve.year}
                            </p>
                            <div class="flex justify-center items-center">
                                <div
                                    class="w-5 h-5 shadow-md rounded-full mr-2"
                                    style={`background-color: ${selectedToReserve.color}`}
                                />
                                <p class="text-gray-500">
                                    Color: {selectedToReserve.color}
                                </p>
                            </div>
                        </div>
                        <div class="flex flex-col p-1 flex-wrap">
                            <p class="text-gray-500">
                                Observers: {selectedToReserve.reservations_count ||
                                    0}
                            </p>
                            <p class="text-gray-500">
                                Status: {getStatus(selectedToReserve)}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-center">
                <div>
                    <p>Start date:</p>
                    <input
                        type="datetime-local"
                        min={now}
                        bind:value={reserveDates.start}
                    />
                </div>
                <div>
                    <p>End date:</p>
                    <input
                        type="datetime-local"
                        min={now}
                        bind:value={reserveDates.end}
                    />
                </div>
            </div>
            <button
                on:click={reserveCar}
                class="flex-1 p-1 m-1 text-accent rounded">Send request</button
            >
        </div>
    </div>
{/if}

<div class="flex flex-wrap -m-2 lg:w-2/3 md:w-1/1 mx-auto">
    <div class="flex justify-center items-center m-2 flex-wrap w-full">
        <p class="text-gray-900 title-font font-medium pb-1">Sort:</p>
        {#each ["id", "year", "reservations_count", "is_reserved"] as itemColumn}
            <button
                on:click={() => sortOffers(itemColumn)}
                class="flex-1 p-1 m-1">{itemColumn}</button
            >
        {/each}
    </div>
    <div class="flex justify-center items-center m-2 flex-wrap w-full">
        <p class="text-gray-900 title-font font-medium pb-1">Filter:</p>
        {#each ["mark", "model", "year", "color", "is_reserved"] as filterKey}
            <div class="flex flex-row m-3">
                <label for={filterKey}>
                    {filterKey}
                </label>
                <select name="role" id="role" bind:value={filterObj[filterKey]}>
                    {#each getValuesForKey(filterKey) as val}
                        <option value={val}>{val}</option>
                    {/each}
                </select>
            </div>
        {/each}
    </div>

    {#each filteredList as item}
        <div class="p-1 w-full">
            <div
                class="h-full flex items-center border-gray-200 border p-4 rounded-lg"
            >
                <div
                    class="flex-grow flex flex-row justify-center items-center flex-wrap"
                >
                    <h2
                        class="text-gray-900 title-font font-medium pb-1 flex-1"
                    >
                        {item.mark}
                        {item.model}
                    </h2>
                    <div
                        class="flex-grow flex flex-row justify-center flex-wrap flex-auto"
                    >
                        <div class="flex flex-col p-1 border-r-2 flex-1">
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
                        <div class="flex flex-col p-1 flex-wrap flex-1">
                            <p class="text-gray-500">
                                Observers: {item.reservations_count || 0}
                            </p>
                            <p class="text-gray-500">
                                Status: {getStatus(item)}
                            </p>
                        </div>
                    </div>
                    <div class="flex-1">
                        <button
                            on:click={() => selectToReserve(item)}
                            class="flex-1 p-1 m-1 text-accent rounded"
                            >Reserve Car</button
                        >
                    </div>
                </div>
            </div>
        </div>
    {/each}
</div>
