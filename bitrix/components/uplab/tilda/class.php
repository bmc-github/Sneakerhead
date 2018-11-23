<?

use Bitrix\Main\Loader;
use Uplab\Tilda\Common;

/**
 * @property array arResult
 * @property array arParams
 */
class UplabTildaComponent extends CBitrixComponent
{

	/**
	 * подготавливает входные параметры
	 *
	 * @param $params
	 * @return array
	 */
	public function onPrepareComponentParams($params) {
		$params["STOP_CACHE"] = $params["STOP_CACHE"] == "Y" ? "Y" : "N";
		$params["PAGE"] = intval($params["PAGE"]);
		$params["PROJECT"] = intval($params["PROJECT"]);

		return $params;
	}

	protected function getResult() {
		if (!Loader::includeModule("uplab.tilda")) return;

		$this->arResult = array();

		if ($this->arParams["STOP_CACHE"] == "Y") {
			$this->arResult["HTML"] = Common::getPageFullContent($this->arParams["PAGE"]);
		} else {
			$this->arResult["HTML"] = Common::getPageContent($this->arParams["PAGE"]);
		}
	}

	public function executeComponent() {
		global $APPLICATION;

		if (!$this->readDataFromCache()) {
			$this->getResult();

			if ($this->arParams["STOP_CACHE"] == "Y") {
				$APPLICATION->RestartBuffer();
				$this->includeComponentTemplate();
				exit();
			} else {
				$this->includeComponentTemplate();
			}
		}
	}

	/**
	 * определяет читать данные из кеша или нет
	 *
	 * @return bool
	 */
	protected function readDataFromCache() {
		return false;
	}
}