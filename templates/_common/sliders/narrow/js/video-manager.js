/**
 * Управлять прозрачностью слайдера, оставшегося уровнем ниже
 */
function switchSliderOpacity(transparecy){
    document.getElementById('images-container').style.opacity=(transparecy)? '0.2':'1';
}