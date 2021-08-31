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
 * @Title("MAGETWO-93329: DEPRECATED. Address State Field For UK Customers Remain Option even After Browser Refresh")
 * @Description("Address State Field For UK Customers Remain Option even After Browser Refresh<h3 class='y-label y-label_status_broken'>Deprecated Notice(s):</h3><ul><li>Use StorefrontAddressStateFieldForUKCustomerRemainOptionAfterRefreshTest instead</li></ul><h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/AddressStateFieldForUKCustomerRemainOptionAfterRefreshTest.xml<br>")
 * @TestCaseId("MAGETWO-93329")
 * @group checkout
 */
class AddressStateFieldForUKCustomerRemainOptionAfterRefreshTestCest
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
	 * @Features({"Checkout"})
	 * @Stories({"Guest checkout"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AddressStateFieldForUKCustomerRemainOptionAfterRefreshTest(AcceptanceTester $I, \Codeception\Scenario $scenario)
	{
		$scenario->skip("This test is skipped due to the following issues:\nUse StorefrontAddressStateFieldForUKCustomerRemainOptionAfterRefreshTest instead");
	}
}
