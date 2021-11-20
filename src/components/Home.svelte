<script>
    import { API_PATH } from "../constants";

    let cars = [];

    const loadCars = async () => {
        const res = await fetch(`${API_PATH}public/getCars.php`);
        const d = await res.json();
        if (d.success) {
            cars = [...d.msg];
        }
    };

    loadCars();
</script>

<div class="flex justify-center flex-col items-center p-1">
    <section class="text-gray-600 body-font w-full">
        <div class="container px-5 py-10 mx-auto">
            <div class="flex flex-col text-center w-full mb-20">
                <h1
                    class="sm:text-3xl text-2xl font-medium title-font mb-1 text-primary"
                >
                    Car rental Project
                </h1>
                <p class="lg:w-2/3 mx-auto leading-relaxed text-base mb-2">
                    Simple page enabling clients to request for a rent of a car
                    for a period of time. Also enable administrators to
                    accept/rejects requests
                </p>
                <p class="pt-12 text-xl">Features</p>
                <ul>
                    <li class="flex justify-center items-center">
                        <div
                            class="w-2 h-2 shadow-md rounded-full mr-2 bg-primary"
                        />
                        <p>accounts</p>
                    </li>
                    <li class="flex justify-center items-center">
                        <div
                            class="w-2 h-2 shadow-md rounded-full mr-2 bg-primary"
                        />
                        <p>displaying reservation offerts</p>
                    </li>
                    <li class="flex justify-center items-center">
                        <div
                            class="w-2 h-2 shadow-md rounded-full mr-2 bg-primary"
                        />
                        <p>admin page</p>
                    </li>
                </ul>
                <div>
                    <p class="pt-12 pb-8 text-xl">Our cars</p>
                    {#each cars as car}
                        <div
                            class="h-full flex items-center border-gray-200 border p-4 rounded-lg -m-2 lg:w-2/3 md:w-1/1 mx-auto"
                        >
                            <div
                                class="flex-grow flex flex-row justify-center flex-wrap flex-auto"
                            >
                                <div class="flex flex-row p-3">
                                    <p class="text-gray-500 p-1 border-r-2">
                                        {car.mark}
                                        {car.model}
                                    </p>
                                    <div
                                        class="flex justify-center items-center p-1"
                                    >
                                        <p class="text-gray-500">
                                            Year: {car.year}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {/each}
                </div>
            </div>
        </div>
    </section>
    <footer class="flex mt-20 justify-between text-gray-600 body-font w-full">
        <p>© 2021-2022 NoMariusz</p>
        <a href="./assets/statue.pdf" target="blank">Statue of the service </a>
    </footer>
</div>
