import * as $ from 'jquery'
import Textarea from './textarea'
declare const Data: any;

const doc = $(document)
const win = $(window)

// Win
// const text = [
//   `I, as player #${Data.id}, hereby proclaim that I want to win this game`,
//   ', with full awareness of the fact that all games',
//   ' can essentially be divided into two mutually exclusive genres:',
//   ' the ones I want to win and the ones I don’t.',
//   ' This exact game, to me, applies to the former category.',
//   ' Hence, I once again clarify that the aforementioned decision is made out of free will',
//   ' as a voluntary act and deed,',
//   ' under no influence of any chemical substances',
//   ' or peer pressure,',
//   ' and without any duress or coercion of any form',
//   ' exerted by or on behalf of any other organization or individual.'
// ]
const text = [
  '111111', '2222222'
]
const textLengthMap = text.reduce(function(acc, value) {
  const len = value.length
  acc.push(acc.length ? acc[acc.length - 1] + len - 4 : len - 4)
  return acc
}, [])

function getOrigin(len) : string[] {
  for (let i = 0, ilen = text.length; i < ilen; i++) {
    if (textLengthMap[i] > len) {
      return text.slice(0, i + 1)
    }
  }
  return text
}

const btnWin = $('#btn-win')
const textareaWin = new Textarea({
  el: $('#textarea-win'),
  onChange: function(value) {
    const texts = getOrigin(value.length)
    this.el.toggleClass('is-expanded', texts.length > 1)
    this.setHint(texts.join(''))
    btnWin.prop('disabled', value !== this.hint)
  },
  hint: getOrigin(0).join(''),
})
textareaWin.render()

$('#btn-win').click(function(e) {
  if ($(e.target).is(':disabled')) { return }
  if (!confirm('Is this your final choice?')) { return }
  $.ajax('./choose_to_win.php').then(function() {
    renderWin()
  })
})

// Lose
const btnLose = $('#btn-lose')
const minLength = 20
const textareaLose = new Textarea({
  el: $('#textarea-lose'),
  onChange: function(value) {
    btnLose.prop('disabled', value.length < minLength)
  },
  maxLength: 255,
})
textareaLose.render()

$('#btn-lose').click(function(e) {
  if ($(e.target).is(':disabled')) { return }
  if (!confirm('Is this your final choice?')) { return }
  $.ajax('./choose_to_lose.php', {
    type: 'POST',
    data: {
      comment: textareaLose.value
    },
  }).then(function() {
    location.reload()
  })
})

function renderWin() {

}