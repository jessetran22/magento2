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
 * @Title("MC-10905: DEPRECATED: Create Custom Product Attribute Dropdown Field (Not Required) from Product Page")
 * @Description("login as admin and create configurable product attribute with Dropdown field<h3 class='y-label y-label_status_broken'>Deprecated Notice(s):</h3><ul><li>Use AdminVerifyCreateCustomProductAttributeTest</li></ul><h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCreateCustomProductAttributeWithDropdownFieldTest.xml<br>")
 * @TestCaseId("MC-10905")
 * @group mtf_migrated
 */
class AdminCreateCustomProductAttributeWithDropdownFieldTestCest
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
    }
	/**
	 * @Stories({"Create product Attribute"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateCustomProductAttributeWithDropdownFieldTest(AcceptanceTester $I, \Codeception\Scenario $scenario)
	{
		$scenario->skip("This test is skipped due to the following issues:\nUse AdminVerifyCreateCustomProductAttributeTest");
	}
}
