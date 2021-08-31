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
 * @Title("MC-148: DEPRECATED. Admin should be able to apply the catalog price rule by product attribute")
 * @Description("Admin should be able to apply the catalog price rule by product attribute<h3 class='y-label y-label_status_broken'>Deprecated Notice(s):</h3><ul><li>Use AdminApplyCatalogPriceRuleByProductAttributeTest</li></ul><h3>Test files</h3>app/code/Magento/CatalogRule/Test/Mftf/Test/ApplyCatalogPriceRuleByProductAttributeTest.xml<br>")
 * @TestCaseId("MC-148")
 * @group CatalogRule
 */
class ApplyCatalogPriceRuleByProductAttributeTestCest
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
	 * @Stories({"Catalog price rule"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"CatalogRule"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function ApplyCatalogPriceRuleByProductAttributeTest(AcceptanceTester $I, \Codeception\Scenario $scenario)
	{
		$scenario->skip("This test is skipped due to the following issues:\nUse AdminApplyCatalogPriceRuleByProductAttributeTest instead.");
	}
}
