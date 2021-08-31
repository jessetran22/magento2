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
 * @Title("MAGETWO-96537: DEPRECATED. Checkout Free Shipping Recalculation after Coupon Code Added")
 * @Description("User should be able to do checkout free shipping recalculation after adding coupon code<h3 class='y-label y-label_status_broken'>Deprecated Notice(s):</h3><ul><li>Use StoreFrontFreeShippingRecalculationAfterCouponCodeAppliedTest instead</li></ul><h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StoreFrontFreeShippingRecalculationAfterCouponCodeAddedTest.xml<br>")
 * @TestCaseId("MAGETWO-96537")
 * @group Checkout
 */
class StoreFrontFreeShippingRecalculationAfterCouponCodeAddedTestCest
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
	 * @Stories({"Checkout Free Shipping Recalculation after Coupon Code Added"})
	 * @Features({"Checkout"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StoreFrontFreeShippingRecalculationAfterCouponCodeAddedTest(AcceptanceTester $I, \Codeception\Scenario $scenario)
	{
		$scenario->skip("This test is skipped due to the following issues:\nUse StoreFrontFreeShippingRecalculationAfterCouponCodeAppliedTest instead");
	}
}
