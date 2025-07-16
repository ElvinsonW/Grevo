<div class="flex flex-col mx-[5vw] my-[2vw]">
    <h1 class="text-[2vw] font-bold mb-[3vw]">Carbon Footprint Calculator</h1>

    <div class="flex flex-col justify-center items-center mb-[3vw]">
        <div class="flex flex-col w-fit gap-[0.5vw]">
            <h3 class="text-[1.4vw] font-bold">Pertanyaan {{ $step }} dari 12</h3>
            <div class="w-[70vw] h-[1vw] rounded-[10vw] bg-gray-200">
                <div class=" h-full rounded-[10vw] bg-green-2" style="width: {{ $this->progress }}%;"></div>
            </div>
        </div>
    </div>

    <div class="flex flex-col items-center">
        <div class="w-[60%]">
            @if ($step == 1)
                @includeif("User.carbon-calculator.question-list.question1")
            @elseif ($step == 2)
                @includeif("User.carbon-calculator.question-list.question2")
            @elseif ($step == 3)
                @includeif("User.carbon-calculator.question-list.question3")
            @elseif ($step == 4)
                @includeif("User.carbon-calculator.question-list.question4")
            @elseif ($step == 5)
                @includeif("User.carbon-calculator.question-list.question5")
            @elseif ($step == 6)
                @includeif("User.carbon-calculator.question-list.question6")
            @elseif ($step == 7)
                @includeif("User.carbon-calculator.question-list.question7")
            @elseif ($step == 8)
                @includeif("User.carbon-calculator.question-list.question8")
            @elseif ($step == 9)
                @includeif("User.carbon-calculator.question-list.question9")
            @elseif ($step == 10)
                @includeif("User.carbon-calculator.question-list.question10")
            @elseif ($step == 11)
                @includeif("User.carbon-calculator.question-list.question11")
            @elseif ($step == 12)
                @includeif("User.carbon-calculator.question-list.question12")
            @endif

            <div class="flex justify-center mb-[1.5vw]">
                <p class="text-red-600 text-[1.3vw] font-bold">{{ $this->error }}</p>
            </div>

            <div class="flex justify-between">
                <button wire:click="prevStep" class="cursor-pointer px-[3vw] py-[0.5vw] rounded-[0.5vw] border border-green-2 font-bold text-green-2">Prev</button>
                @if ($step != 12)
                    <button wire:click="nextStep" class="cursor-pointer px-[3vw] py-[0.5vw] rounded-[0.5vw] bg-green-2 font-bold text-white">Next</button>
                @else
                    <button id="endBtn" class="cursor-pointer px-[3vw] py-[0.5vw] rounded-[0.5vw] bg-green-2 font-bold text-white">End</button>
                @endif
            </div>

            <div id="confirmationDialog" class="fixed top-0 left-0 w-full h-full hidden justify-center items-center" style="background: rgba(0, 0, 0, 0.5)">
                <div class="bg-yellow-3 w-fit p-[2vw] rounded-[0.5vw]">
                    <h2 class="text-xl font-bold mb-4">Are you sure you want to finish the Questionnaire?</h2>
                    <div class="flex justify-end space-x-4">
                        <button id="cancelButton" class="cursor-pointer px-4 py-2 bg-gray-200 font-bold rounded">Cancel</button>
                        <button wire:click="endQuestioner" id="confirmButton" class="cursor-pointer px-4 py-2 bg-orange-1 text-white font-bold rounded">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    const observer = new MutationObserver(() => {
        const endBtn = document.getElementById("endBtn");
        if (endBtn) {
            observer.disconnect(); // Stop observing once the button is found
            endBtn.addEventListener("click", function () {
                const confirmation = document.getElementById("confirmationDialog");
                confirmation.classList.toggle("hidden");
                confirmation.classList.toggle("flex");
            });
        }
    });

    observer.observe(document.body, { childList: true, subtree: true });
});



</script>

