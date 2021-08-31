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
 * @Title("[NO TESTCASEID]: Category with Layered Navigation - verify absence of category filter")
 * @Description("Verify that the category filter is NOT present in layered navigation on category page<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/StorefrontCategoryPageWithoutCategoryFilterTest.xml<br>")
 * @group Catalog
 */
class StorefrontCategoryPageWithoutCategoryFilterTestCest
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
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Create one category");
		$defaultCategoryFields['name'] = "TopCategory";
		$I->createEntity("defaultCategory", "hook", "_defaultCategory", [], $defaultCategoryFields); // stepKey: defaultCategory
		$I->comment("Create second category, having as parent the 1st one");
		$subCategoryFields['name'] = "SubCategory";
		$subCategoryFields['parent_id'] = $I->retrieveEntityField('defaultCategory', 'id', 'hook');
		$I->createEntity("subCategory", "hook", "SubCategoryWithParent", ["defaultCategory"], $subCategoryFields); // stepKey: subCategory
		$I->comment("Create a product assigned to the 1st category");
		$I->createEntity("createSimpleProduct1", "hook", "_defaultProduct", ["defaultCategory"], []); // stepKey: createSimpleProduct1
		$I->comment("Create 2nd product assigned to the 2nd category");
		$I->comment("The \"Category filter\" item is not shown in layered navigation");
		$I->comment("if there are not subcategories with products to show");
		$I->createEntity("createSimpleProduct2", "hook", "_defaultProduct", ["subCategory"], []); // stepKey: createSimpleProduct2
		$I->comment("Set the category filter to NOT be present on the category page layered navigation");
		$hideCategoryFilterOnStorefront = $I->magentoCLI("config:set catalog/layered_navigation/display_category 0", 60); // stepKey: hideCategoryFilterOnStorefront
		$I->comment($hideCategoryFilterOnStorefront);
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createSimpleProduct1", "hook"); // stepKey: deleteProduct1
		$I->deleteEntity("createSimpleProduct2", "hook"); // stepKey: deleteProduct2
		$I->deleteEntity("subCategory", "hook"); // stepKey: deleteSubCategory
		$I->deleteEntity("defaultCategory", "hook"); // stepKey: deleteCategoryMainCategory
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _failed(AcceptanceTester $I)
	{
		$I->saveScreenshot(); // stepKey: saveScreenshot
	}

	/**
	 * @Stories({"Category page: Layered Navigation without category filter"})
	 * @Features({"Catalog"})
	 * @Severity(level = SeverityLevel::TRIVIAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCategoryPageWithoutCategoryFilterTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToCategoryPage] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Open category page on storefront");
		$I->amOnPage("/" . $I->retrieveEntityField('defaultCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateStorefrontCategoryPageNavigateToCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadNavigateToCategoryPage
		$I->comment("Exiting Action Group [navigateToCategoryPage] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Entering Action Group [checkCategoryFilterIsNotPresent] AssertStorefrontLayeredNavigationCategoryFilterNotVisibleActionGroup");
		$I->comment("Verify category filter item is NOT present");
		$I->dontSee("Category", "#layered-filter-block"); // stepKey: seeCategoryFilterInLayeredNavCheckCategoryFilterIsNotPresent
		$I->comment("Exiting Action Group [checkCategoryFilterIsNotPresent] AssertStorefrontLayeredNavigationCategoryFilterNotVisibleActionGroup");
	}
}
