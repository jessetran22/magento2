<?php
namespace Magento\AcceptanceTest\_default\Backend;

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
 * @Title("MC-10910: DEPRECATED [Security] Verify No XSS Injection on Update Customer Information Add Address")
 * @Description("Test log in to Storefront and Verify No XSS Injection on Update Customer Information Add Address<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/StorefrontVerifyNoXssInjectionOnUpdateCustomerInformationAddAddressTest.xml<br>")
 * @TestCaseId("MC-10910")
 * @group customer
 * @group mtf_migrated
 */
class StorefrontVerifyNoXssInjectionOnUpdateCustomerInformationAddAddressTestCest
{
	/**
	 * @Stories({"Update Customer Address"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Customer"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontVerifyNoXssInjectionOnUpdateCustomerInformationAddAddressTest(AcceptanceTester $I, \Codeception\Scenario $scenario)
	{
		$scenario->skip("This test is skipped due to the following issues:\nTest outdated");
	}
}
