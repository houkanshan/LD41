import * as $ from 'jquery'
import Textarea from './textarea'
import { renderMarquee } from './marquee'
declare const Data: any;

const doc = $(document)
const win = $(window)
const body = $(document.body)

// Billboard
renderMarquee($('#section-billboard p'))

// Time
const startTime = Date.now()
let timeHandler = null
const timeEl = $('.elapsed')
function updateElapsed() {
  const t = ((Date.now() - startTime) / 1000).toFixed(3)
  timeEl.text(t)
}
if (Data.isActive) {
  setTimeout(function next() {
    updateElapsed();
    timeHandler = setTimeout(next, 30)
  }, 30)
}

// Win
let text = [
  `I, as player #${Data.idStr}, hereby proclaim that I want to win this game`,
  ', with full awareness of the fact that all games',
  ' can essentially be divided into two mutually exclusive genres:',
  ' the ones I want to win and the ones I don\'t.',
  ' This exact game, to me, applies to the former category.',
  ' Hence, I once again clarify that the aforementioned decision is made out of free will',
  ' as a voluntary act and deed,',
  ' under no influence of any chemical substances',
  ' or peer pressure,',
  ' and without any duress or coercion of any form',
  ' exerted by or on behalf of any other organization or individual.'
]
// text = [
//   '1 1', '2 2'
// ]
const textLengthMap = text.reduce(function(acc, value) {
  const len = value.length
  acc.push(acc.length ? acc[acc.length - 1] + len  : len )
  return acc
}, [])

function getOrigin(len) : string[] {
  for (let i = 0, ilen = text.length; i < ilen; i++) {
    if (textLengthMap[i] > len) {
      const words = text[i].split(' ')
      const wordLen = words[words.length - 1].length
      if (textLengthMap[i] > len + wordLen) {
        return text.slice(0, i + 1)
      }
    }
  }
  return text
}

const btnWin = $('#btn-win')
const countWrong = $('#count-wrong')
const textareaWin = new Textarea({
  el: $('#textarea-win'),
  onChange: function(value, wrongCount) {
    const texts = getOrigin(value.length)
    this.el.toggleClass('is-expanded', texts.length > 1)
    this.setHint(texts.join(''))
    btnWin.prop('disabled', value !== this.hint)
    countWrong.toggle(wrongCount !== 0).text(`${wrongCount} error${wrongCount > 1 ? 's' : ''}`)
  },
  hint: getOrigin(0).join(''),
})
textareaWin.render()
if (Data.isActive) {
  textareaWin.focus()
}

$('#btn-win').click(function(e) {
  if ($(e.target).is(':disabled')) { return }
  if (!confirm('Is this your final choice?')) { return }
  $.ajax('./choose_to_win.php').then(function(winNumber) {
    renderWin(winNumber)
  })
})

// Lose
const btnLose = $('#btn-lose')
const textareaLose = new Textarea({
  el: $('#textarea-lose'),
  onChange: function(value) {
    const len = value.length
    btnLose.prop('disabled', len < this.minLength || len > this.maxLength)
  },
  minLength: 15,
  maxLength: 140,
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

function renderWin(winNumber) {
  clearTimeout(timeHandler)
  const elapsed = Date.now() - startTime
  updateElapsed();
  $('.winner-number').text(winNumber)
  body.attr('data-state', 'win')
}

$('.close').click(function() {
  $('.banner').toggleClass('truly-closed')
})