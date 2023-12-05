<?php
namespace common\components;

use Yii;

class MethodGenerator
{
    public function generateMethod($controllerName, $methodName, $parameters, $modelNamespace, $modelClass, $methodBody)
    {
        $parametersStr = implode(', ', $parameters);

        // Создаем use-инструкцию для модели
        $useStatements = "use $modelNamespace\\$modelClass;\n";

        $methodCode = $useStatements; // Добавляем use-инструкции
        $methodCode .= "class $controllerName {\n";
        $methodCode .= "    public function $methodName($parametersStr) {\n";
        $methodCode .= "        \$model = new $modelClass();\n"; // Создаем экземпляр модели
        $methodCode .= "        $methodBody\n";
        $methodCode .= "    }\n";
        $methodCode .= "}\n";

        // Удаляем символ '\' из имени класса модели
        $modelClassName = str_replace('\\', '', $modelClass);

        // Определяем путь для сохранения сгенерированного кода
        $filePath = Yii::getAlias('@backend/modules/bots/controllers/') . "$controllerName.php";

        // Создаем файл и записываем в него код
        file_put_contents($filePath, '<?php' . PHP_EOL . $methodCode);

        // Определяем пространство имен
        $namespace = "backend\modules\bots\controllers";
        // Загружаем сгенерированный класс
        require($filePath);
    }
}
