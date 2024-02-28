Vue.component('question-list', {
    data: function () {
        return {
            questions: [], selectedOptions: [], resultStats: {}, testResults: null
        }
    },
    created: function () {
        this.fetchQuestions();
        this.fetchResults();
    },
    methods: {
        fetchQuestions: function () {
            this.questions = [];
            axios.get('/api/testing/questions')
                .then(response => {
                    this.questions = response.data.questions;
                })
                .catch(error => {
                    console.error('There was an error fetching the questions: ', error);
                });
        },
        fetchResults: function () {
            axios.get('/api/testing/results')
                .then(response => {
                    this.resultStats = response.data;
                })
                .catch(error => {
                    console.error('There was an error fetching the results: ', error);
                });
        },
        clearResults: function () {
            axios.delete('/api/testing/results')
                .then(response => {
                    this.fetchResults();
                })
                .catch(error => {
                    console.error('There was an error clearing the results: ', error);
                });
        },
        recreateTest: function () {
            this.testResults = null;
            this.selectedOptions = [];
            this.fetchQuestions();
        },
        submitAnswers: function () {
            axios.post('/api/testing/evaluate', {
                selectedOptions: this.selectedOptions
            })
                .then(response => {
                    this.testResults = response.data.correctAnswers;
                    this.fetchResults();
                })
                .catch(error => {
                    console.error('There was an error submitting the answers: ', error);
                });
        },
        updateAnswers: function (questionId, optionId, isChecked) {
            const answerIndex = this.selectedOptions.indexOf(optionId)

            if (isChecked && answerIndex === -1) {
                this.selectedOptions.push(optionId);
            } else if (!isChecked && answerIndex !== -1) {
                this.selectedOptions.splice(answerIndex, 1);
            }
        }
    },
    template: `
        <main style="margin: 50px auto 0;" class="row">
                <div class="five columns" v-if="resultStats">
                    <h3>Result Stats</h3>
                    <table>
                        <tr>
                            <td>submitted results</td><td> {{resultStats.submittedResults}} </td>
                        </tr>
                        <tr>
                            <td>correct answers</td><td> {{resultStats.correctAnswers}} </td>
                        </tr>
                        <tr>
                            <td>wrong answers</td><td> {{resultStats.wrongAnswers}} </td>
                        </tr>
                    </table>
                    <button class="nav-link active" @click="clearResults">Clear Stats</button>
                </div>
                <div class="four columns">
                    <h3>Test Questions</h3>
                    <ul>
                        <li style="text-align: left; margin-top: 10px" v-for="question in questions" :key="question.questionId">
                            <code :class="[!testResults ? '' : (testResults.includes(question.questionId) ? 'green' : 'red')]">
                                {{ question.expression }}
                            </code> ?
                            <ol>
                                <li v-for="option in question.options" :key="option.optionId">
                                    <input
                                        type="checkbox"
                                        @change="updateAnswers(question.questionId, option.optionId, $event.target.checked)"
                                    > {{ option.expression }}
                                </li>
                            </ol>
                            
                        </li>
                    </ul>
                    <button v-if="testResults" class="nav-link active" @click="recreateTest">Recreate Test</button>
                    <button v-if="!testResults" class="nav-link active" @click="submitAnswers">Submit Answers</button>
                </div>

            </center>
        </main>
    `
});

new Vue({
    el: '#app'
});
