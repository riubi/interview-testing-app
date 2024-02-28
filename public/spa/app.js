Vue.component('question-list', {
    data: function () {
        return {
            questions: [], answers: [], results: {}
        }
    },
    created: function () {
        this.fetchQuestions();
        this.fetchResults();
    },
    methods: {
        fetchQuestions: function () {
            axios.get('/api/testing/questions')
                .then(response => {
                    this.questions = response.data.questions;
                })
                .catch(error => {
                    console.error('There was an error fetching the questions: ', error);
                });
        },
        fetchResults: function () {
            axios.get('/api/testing/results', this.answers)
                .then(response => {
                    this.results = response.data;
                })
                .catch(error => {
                    console.error('There was an error fetching the results: ', error);
                });
        },
        clearResults: function () {
            axios.delete('/api/testing/results', this.answers)
                .then(response => {
                    this.fetchResults();
                })
                .catch(error => {
                    console.error('There was an error clearing the results: ', error);
                });
        },
        submitAnswers: function () {
            axios.post('/api/testing/evaluate', {
                answers: this.answers
            })
                .then(response => {
                    this.fetchResults();
                    this.fetchQuestions();
                })
                .catch(error => {
                    console.error('There was an error submitting the answers: ', error);
                });
        },
        updateAnswers: function (questionId, optionId, isChecked) {
            const answerIndex = this.answers.indexOf(optionId)

            if (isChecked && answerIndex === -1) {
                this.answers.push(optionId);
            } else if (!isChecked && answerIndex !== -1) {
                this.answers.splice(answerIndex, 1);
            }
        }
    },
    template: `
        <main style="margin: 50px auto 0;" class="row">
                <div class="five columns" v-if="results">
                    <h3>Result Stats</h3>
                    <table>
                        <tr>
                            <td>submitted results</td><td> {{results.submittedResults}} </td>
                        </tr>
                        <tr>
                            <td>correct answers</td><td> {{results.correctAnswers}} </td>
                        </tr>
                        <tr>
                            <td>wrong answers</td><td> {{results.wrongAnswers}} </td>
                        </tr>
                    </table>
                    <button class="nav-link active" @click="clearResults">Clear Stats</button>
                </div>
                <div class="four columns">
                    <h3>Test Questions</h3>
                    <ul>
                        <li style="text-align: left; margin-top: 10px" v-for="question in questions" :key="question.questionId">
                            <code> {{ question.expression }} </code> ?
                            <ul>
                                <li v-for="option in question.options" :key="option.optionId">
                                    <input
                                        type="checkbox"
                                        :value="option.optionId"
                                        :id="option.optionId"
                                        @change="updateAnswers(question.questionId, option.optionId, $event.target.checked)"
                                    > {{ option.expression }}
                                </li>
                            </ul>
                            
                        </li>
                    </ul>
                    <button class="nav-link active" @click="submitAnswers">Submit Answers</button>
                </div>

            </center>
        </main>
    `
});

new Vue({
    el: '#app'
});
