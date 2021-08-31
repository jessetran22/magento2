<?php
namespace Magento\AcceptanceTest\_MagentoDeveloperModeOnlyTestSuite\Backend;

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
 * @Title("MC-27118: Buttons inline translation")
 * @Description("A merchant should be able to translate buttons by an inline translation tool<h3>Test files</h3>app/code/Magento/Translation/Test/Mftf/Test/StorefrontButtonsInlineTranslationTest.xml<br>")
 * @TestCaseId("MC-27118")
 * @group translation
 * @group catalog
 * @group developer_mode_only
 */
class StorefrontButtonsInlineTranslationTestCest
{
	/**
	 * @Features({"Translation"})
	 * @Stories({"Inline Translation"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontButtonsInlineTranslationTest(AcceptanceTester $I, \Codeception\Scenario $scenario)
	{
		$scenario->skip("This test is skipped due to the following issues:\nUse StorefrontButtonsInlineTranslationOnProductPageTest instead");
	}
}
