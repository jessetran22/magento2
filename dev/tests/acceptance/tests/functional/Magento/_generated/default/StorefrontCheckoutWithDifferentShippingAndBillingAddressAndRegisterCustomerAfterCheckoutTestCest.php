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
 * @Title("MC-14712: DEPRECATED. Verify UK customer checkout with different billing and shipping address and register customer after checkout")
 * @Description("Checkout as UK customer with different shipping/billing address and register checkout method<h3 class='y-label y-label_status_broken'>Deprecated Notice(s):</h3><ul><li>Use StorefrontCheckoutWithDifferentShippingAndBillingAddressAndCreateCustomerAfterCheckoutTest instead</li></ul><h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontCheckoutWithDifferentShippingAndBillingAddressAndRegisterCustomerAfterCheckoutTest.xml<br>")
 * @TestCaseId("MC-14712")
 * @group mtf_migrated
 */
class StorefrontCheckoutWithDifferentShippingAndBillingAddressAndRegisterCustomerAfterCheckoutTestCest
{
    /**
     * @var \Magento\FunctionalTestingFramework\Helper\HelperContainer
     */
    private $helperContainer;

    /**
     * Special method which automatically creates the respective objects.
     */
    public function _inject(\Magento\FunctionalTestingFramework\Helper\HelperContainer $helperContainer)
    {
        $this->helperContainer = $helperContainer;
        $this->helperContainer->create("Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	 * @Stories({"Checkout"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Checkout"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCheckoutWithDifferentShippingAndBillingAddressAndRegisterCustomerAfterCheckoutTest(AcceptanceTester $I, \Codeception\Scenario $scenario)
	{
		$scenario->skip("This test is skipped due to the following issues:\nUse StorefrontCheckoutWithDifferentShippingAndBillingAddressAndCreateCustomerAfterCheckoutTest instead");
	}
}
