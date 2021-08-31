<?php
namespace Magento\AcceptanceTest\_WYSIWYGDisabledSuite\Backend;

use Magento\FunctionalTestingFramework\AcceptanceTester;
use \Codeception\Util\Locator;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;
use Yandex\Allure\Adapter\Annotation\Description;
use Yandex\Allure\Adapter\Annotation\Parameter;
use Yandex\Allure\Adapter\Annotation\Severity;
use Yandex\Allure\Adapter\Model\SeverityLevel;
use Yandex\Allure\Adapter\Annotation\TestCaseId;

/**
 * @Title("MC-13794: Deprecated. Checking order of products in the 'catalog Products List' widget")
 * @Description("Check that products are ordered with recently added products first<h3 class='y-label y-label_status_broken'>Deprecated Notice(s):</h3><ul><li>Use CatalogProductListCheckWidgetOrderTest instead</li></ul><h3>Test files</h3>app/code/Magento/CatalogWidget/Test/Mftf/Test/CatalogProductListWidgetOrderTest.xml<br>")
 * @TestCaseId("MC-13794")
 * @group CatalogWidget
 * @group WYSIWYGDisabled
 */
class CatalogProductListWidgetOrderTestCest
{
	/**
	 * @Features({"CatalogWidget"})
	 * @Stories({"MC-5905: Wrong sorting on Products component"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function CatalogProductListWidgetOrderTest(AcceptanceTester $I, \Codeception\Scenario $scenario)
	{
		$scenario->skip("This test is skipped due to the following issues:\nUse CatalogProductListCheckWidgetOrderTest instead");
	}
}
