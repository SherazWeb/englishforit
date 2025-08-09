<div class="quiz-question p-5 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800"
     x-data="{
         selected: @entangle('selectedOption'),
         submitted: @entangle('isSubmitted'),
         isCorrect: @entangle('isCorrect'),
         explanation: @js($explanation ?? ''),
         correctKey: @js($correctKey) // Pass correctKey from PHP → JS
     }"
     :class="{
         'border-green-200 dark:border-green-800': submitted && isCorrect,
         'border-red-200 dark:border-red-800': submitted && !isCorrect
     }">

    <div class="flex items-start">
        <div class="flex-shrink-0 mr-3 font-semibold text-gray-500 dark:text-gray-400">
            {{ $loop->iteration ?? '' }}.
        </div>
        <div class="flex-1">
            <h4 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-3">
                {!! $question->question !!}
            </h4>

            <div class="space-y-2">
                @foreach($options as $key => $option)
                    <label 
                        x-data="{ myKey: @js($key) }"  {{-- Inject $key into JS --}}
                        class="flex items-center p-3 rounded-lg cursor-pointer transition"
                        :class="{
                            'bg-green-50 dark:bg-green-900/20': submitted && myKey === correctKey,
                            'bg-red-50 dark:bg-red-900/20': submitted && selected === myKey && myKey !== correctKey,
                            'bg-blue-50 dark:bg-blue-900/20': !submitted && selected === myKey,
                            'hover:bg-gray-50 dark:hover:bg-gray-700': !submitted && selected !== myKey
                        }">
                        
                        <input type="radio" 
                               x-model="selected" 
                               :value="myKey"
                               :disabled="submitted"
                               class="form-radio h-4 w-4 text-indigo-600 dark:bg-gray-700 dark:border-gray-600">
                        
                        <span class="ml-3 text-gray-700 dark:text-gray-300">{{ $option }}</span>
                        
                        <!-- Show checkmark for correct answer -->
                        <span x-show="submitted && myKey === correctKey" 
                              class="ml-auto text-green-500">✓</span>
                        
                        <!-- Show cross for incorrect selected answer -->
                        <span x-show="submitted && selected === myKey && myKey !== correctKey" 
                              class="ml-auto text-red-500">✗</span>
                    </label>
                @endforeach
            </div>

            <button @click="$wire.submit()" 
                    :disabled="!selected || submitted"
                    class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition 
                           disabled:opacity-50 disabled:cursor-not-allowed">
                <span x-text="submitted ? 'Answered' : 'Submit Answer'"></span>
            </button>

            <div x-show="submitted && explanation" x-transition
                 class="mt-3 p-3 rounded-lg"
                 :class="{
                     'bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300': isCorrect,
                     'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300': !isCorrect
                 }">
                <span x-text="explanation"></span>
            </div>
        </div>
    </div>
</div>
