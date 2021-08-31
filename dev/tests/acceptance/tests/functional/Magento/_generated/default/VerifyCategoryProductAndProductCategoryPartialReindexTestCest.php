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
 * @Title("MC-11386: DEPRECATED. Verify Category Product and Product Category partial reindex")
 * @Description("Verify that Merchant Developer can use console commands to perform partial reindex for Category Products, Product Categories, and Catalog Search<h3 class='y-label y-label_status_broken'>Deprecated Notice(s):</h3><ul><li>Use StorefrontVerifyCategoryProductAndProductCategoryPartialReindexTest instead.</li></ul><h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/VerifyCategoryProductAndProductCategoryPartialReindexTest.xml<br>")
 * @TestCaseId("MC-11386")
 * @group catalog
 * @group indexer
 */
class VerifyCategoryProductAndProductCategoryPartialReindexTestCest
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
	 * @Features({"Catalog"})
	 * @Stories({"Product Categories Indexer"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function VerifyCategoryProductAndProductCategoryPartialReindexTest(AcceptanceTester $I, \Codeception\Scenario $scenario)
	{
		$scenario->skip("This test is skipped due to the following issues:\nUse StorefrontVerifyCategoryProductAndProductCategoryPartialReindexTest instead.");
	}
}
