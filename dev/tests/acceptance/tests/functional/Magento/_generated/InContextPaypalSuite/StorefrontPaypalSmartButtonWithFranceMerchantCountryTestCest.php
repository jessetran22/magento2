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
 * @Title("MC-33274: Mainflow of Paypal Smart Button with Euro currency and merchant country is France")
 * @Description("Users are able to place order using Paypal Smart Button using Euro currency and merchant country is France<h3>Test files</h3>app/code/Magento/Paypal/Test/Mftf/Test/StorefrontPaypalSmartButtonWithFranceMerchantCountryTest.xml<br>")
 * @TestCaseId("MC-33274")
 * @group paypalExpress
 */
class StorefrontPaypalSmartButtonWithFranceMerchantCountryTestCest
{
	/**
	 * @Features({"Paypal"})
	 * @Stories({"PayPal Express Checkout"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontPaypalSmartButtonWithFranceMerchantCountryTest(AcceptanceTester $I, \Codeception\Scenario $scenario)
	{
		$scenario->skip("This test is skipped due to the following issues:\nMC-37236");
	}
}
