<?php
namespace Magento\AcceptanceTest\_InContextPaypalSuite\Backend;

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
 * @Title("MC-28711: Check PayPal Smart Button configuration with Checkout label on Cart page")
 * @Description("Admin is able to customize PayPal Smart Button with Checkout label on Cart page<h3>Test files</h3>app/code/Magento/Paypal/Test/Mftf/Test/StorefrontCheckPayPalSmartButtonWithCheckoutLabelOnCartPageTest.xml<br>")
 * @TestCaseId("MC-28711")
 * @group paypal
 * @group paypalExpress
 */
class StorefrontCheckPayPalSmartButtonWithCheckoutLabelOnCartPageTestCest
{
	/**
	 * @Features({"Paypal"})
	 * @Stories({"PayPal Smart Button Configuration"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCheckPayPalSmartButtonWithCheckoutLabelOnCartPageTest(AcceptanceTester $I, \Codeception\Scenario $scenario)
	{
		$scenario->skip("This test is skipped due to the following issues:\nMC-33951");
	}
}
