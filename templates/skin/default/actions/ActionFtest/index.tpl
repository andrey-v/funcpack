<form action="" method="post">
    <label for="word">
        Введите слово для склонения:
    </label>
    <input id="word" type="text" name="word"/>
    <button type="submit">Отправить</button>
</form>

{if isset($sWord)}
    <strong>Именительный:</strong>
    {P::L($sWord, 1)}
    <br/>
    <strong>Родительный:</strong>
    {P::L($sWord, 2)}
    <br/>
    <strong>Дательный:</strong>
    {P::L($sWord, 3)}
    <br/>
    <strong>Винительный:</strong>
    {P::L($sWord, 4)}
    <br/>
    <strong>Творительный:</strong>
    {P::L($sWord, 5)}
    <br/>
    <strong>Предложный:</strong>
    {P::L($sWord, 6)}
    <br/>
{/if}

