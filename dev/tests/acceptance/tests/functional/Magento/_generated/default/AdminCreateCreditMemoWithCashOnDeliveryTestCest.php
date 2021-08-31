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
 * @Title("MC-15863: DEPRECATED. Create Credit Memo with cash on delivery payment method")
 * @Description("Create Credit Memo with cash on delivery payment and assert 0 shipping refund<h3 class='y-label y-label_status_broken'>Deprecated Notice(s):</h3><ul><li>Use AdminCreateCreditMemoForOrderWithCashOnDeliveryTest instead</li></ul><h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/AdminCreateCreditMemoWithCashOnDeliveryTest.xml<br>")
 * @TestCaseId("MC-15863")
 * @group sales
 * @group mtf_migrated
 */
class AdminCreateCreditMemoWithCashOnDeliveryTestCest
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
	 * @Stories({"Credit memo entity"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Sales"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateCreditMemoWithCashOnDeliveryTest(AcceptanceTester $I, \Codeception\Scenario $scenario)
	{
		$scenario->skip("This test is skipped due to the following issues:\nUse AdminCreateCreditMemoForOrderWithCashOnDeliveryTest instead");
	}
}
