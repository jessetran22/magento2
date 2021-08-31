<?php
namespace Magento\AcceptanceTest\_SearchEngineElasticsearchSuite\Backend;

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
 * @Title("MC-36326: [ES] Search with Layered Navigation and different types of attribute products.")
 * @Description("Filtering by dropdown attribute in Layered navigation<h3>Test files</h3>app/code/Magento/LayeredNavigation/Test/Mftf/Test/StorefrontDropdownAttributeInLayeredNavigationTest.xml<br>")
 * @TestCaseId("MC-36326")
 * @group layeredNavigation
 * @group catalog
 * @group SearchEngineElasticsearch
 */
class StorefrontDropdownAttributeInLayeredNavigationTestCest
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
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->createEntity("createDropdownProductAttribute", "hook", "dropdownProductAttribute", [], []); // stepKey: createDropdownProductAttribute
		$I->createEntity("firstDropdownProductAttributeOption", "hook", "productAttributeOption", ["createDropdownProductAttribute"], []); // stepKey: firstDropdownProductAttributeOption
		$I->createEntity("secondDropdownProductAttributeOption", "hook", "productAttributeOption", ["createDropdownProductAttribute"], []); // stepKey: secondDropdownProductAttributeOption
		$I->getEntity("getFirstDropdownProductAttributeOption", "hook", "ProductAttributeOptionGetter", ["createDropdownProductAttribute"], null, 1); // stepKey: getFirstDropdownProductAttributeOption
		$I->getEntity("getSecondDropdownProductAttributeOption", "hook", "ProductAttributeOptionGetter", ["createDropdownProductAttribute"], null, 2); // stepKey: getSecondDropdownProductAttributeOption
		$I->createEntity("AddDropdownProductAttributeToAttributeSet", "hook", "AddToDefaultSet", ["createDropdownProductAttribute"], []); // stepKey: AddDropdownProductAttributeToAttributeSet
		$I->createEntity("createFirstProduct", "hook", "ApiSimpleProductWithCategory", ["createDropdownProductAttribute", "getFirstDropdownProductAttributeOption", "createCategory"], []); // stepKey: createFirstProduct
		$I->createEntity("createSecondProduct", "hook", "ApiSimpleProductWithCategory", ["createDropdownProductAttribute", "getSecondDropdownProductAttributeOption", "createCategory"], []); // stepKey: createSecondProduct
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createFirstProduct", "hook"); // stepKey: deleteFirstProduct
		$I->deleteEntity("createSecondProduct", "hook"); // stepKey: deleteSecondProduct
		$I->deleteEntity("createDropdownProductAttribute", "hook"); // stepKey: deleteDropdownProductAttribute
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
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
	 * @Features({"LayeredNavigation"})
	 * @Stories({"Product attributes in Layered Navigation"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontDropdownAttributeInLayeredNavigationTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openCategory] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Open category page on storefront");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateStorefrontCategoryPageOpenCategory
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadOpenCategory
		$I->comment("Exiting Action Group [openCategory] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Entering Action Group [assertFirstAttributeOptionPresentInLayeredNavigation] AssertStorefrontAttributeOptionPresentInLayeredNavigationActionGroup");
		$I->waitForElementVisible("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createDropdownProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", 30); // stepKey: waitForAttributeVisibleAssertFirstAttributeOptionPresentInLayeredNavigation
		$I->conditionalClick("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createDropdownProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", ".filter-options-item.active .items", false); // stepKey: clickToExpandAttributeAssertFirstAttributeOptionPresentInLayeredNavigation
		$I->waitForElementVisible(".filter-options-item.active .items", 30); // stepKey: waitForAttributeOptionsVisibleAssertFirstAttributeOptionPresentInLayeredNavigation
		$I->see($I->retrieveEntityField('getFirstDropdownProductAttributeOption', 'label', 'test'), ".filter-options-item.active .items li:nth-child(1) a"); // stepKey: assertAttributeOptionInLayeredNavigationAssertFirstAttributeOptionPresentInLayeredNavigation
		$I->waitForPageLoad(30); // stepKey: assertAttributeOptionInLayeredNavigationAssertFirstAttributeOptionPresentInLayeredNavigationWaitForPageLoad
		$I->comment("Exiting Action Group [assertFirstAttributeOptionPresentInLayeredNavigation] AssertStorefrontAttributeOptionPresentInLayeredNavigationActionGroup");
		$I->comment("Entering Action Group [assertSecondAttributeOptionPresentInLayeredNavigation] AssertStorefrontAttributeOptionPresentInLayeredNavigationActionGroup");
		$I->waitForElementVisible("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createDropdownProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", 30); // stepKey: waitForAttributeVisibleAssertSecondAttributeOptionPresentInLayeredNavigation
		$I->conditionalClick("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createDropdownProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", ".filter-options-item.active .items", false); // stepKey: clickToExpandAttributeAssertSecondAttributeOptionPresentInLayeredNavigation
		$I->waitForElementVisible(".filter-options-item.active .items", 30); // stepKey: waitForAttributeOptionsVisibleAssertSecondAttributeOptionPresentInLayeredNavigation
		$I->see($I->retrieveEntityField('getSecondDropdownProductAttributeOption', 'label', 'test'), ".filter-options-item.active .items li:nth-child(2) a"); // stepKey: assertAttributeOptionInLayeredNavigationAssertSecondAttributeOptionPresentInLayeredNavigation
		$I->waitForPageLoad(30); // stepKey: assertAttributeOptionInLayeredNavigationAssertSecondAttributeOptionPresentInLayeredNavigationWaitForPageLoad
		$I->comment("Exiting Action Group [assertSecondAttributeOptionPresentInLayeredNavigation] AssertStorefrontAttributeOptionPresentInLayeredNavigationActionGroup");
		$I->comment("Entering Action Group [filterCategoryByFirstOption] StorefrontFilterCategoryPageByAttributeOptionActionGroup");
		$I->waitForElementVisible("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createDropdownProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", 30); // stepKey: waitForFilterVisibleFilterCategoryByFirstOption
		$I->conditionalClick("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createDropdownProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", ".filter-options-item.active .items", false); // stepKey: clickToExpandFilterFilterCategoryByFirstOption
		$I->click("//div[@class='filter-options']//li[@class='item']//a[contains(text(), '" . $I->retrieveEntityField('getFirstDropdownProductAttributeOption', 'label', 'test') . "')]"); // stepKey: clickOnOptionFilterCategoryByFirstOption
		$I->waitForPageLoad(30); // stepKey: clickOnOptionFilterCategoryByFirstOptionWaitForPageLoad
		$I->comment("Exiting Action Group [filterCategoryByFirstOption] StorefrontFilterCategoryPageByAttributeOptionActionGroup");
		$I->comment("Entering Action Group [assertFilterByFirstOption] StorefrontAssertAppliedFilterActionGroup");
		$I->see($I->retrieveEntityField('createDropdownProductAttribute', 'attribute[frontend_labels][0][label]', 'test'), ".filter-current .items > li.item:nth-of-type(1) > span.filter-label"); // stepKey: seeAppliedFilterLabelAssertFilterByFirstOption
		$I->see($I->retrieveEntityField('getFirstDropdownProductAttributeOption', 'label', 'test'), ".filter-current .items > li.item:nth-of-type(1) > span.filter-value"); // stepKey: seeAppliedFilterValueAssertFilterByFirstOption
		$I->comment("Exiting Action Group [assertFilterByFirstOption] StorefrontAssertAppliedFilterActionGroup");
		$I->comment("Entering Action Group [assertFirstProductOnCatalogPage] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createFirstProduct', 'name', 'test') . "')]", 30); // stepKey: assertProductNameAssertFirstProductOnCatalogPage
		$I->comment("Exiting Action Group [assertFirstProductOnCatalogPage] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->comment("Entering Action Group [assertSecondProductIsMissingOnCatalogPage] StorefrontCheckProductIsMissingInCategoryProductsPageActionGroup");
		$I->dontSee("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createSecondProduct', 'name', 'test') . "')]"); // stepKey: dontSeeCorrectProductsOnStorefrontAssertSecondProductIsMissingOnCatalogPage
		$I->comment("Exiting Action Group [assertSecondProductIsMissingOnCatalogPage] StorefrontCheckProductIsMissingInCategoryProductsPageActionGroup");
		$I->click("div.filter-current .remove"); // stepKey: removeSideBarFilter
		$I->waitForPageLoad(30); // stepKey: removeSideBarFilterWaitForPageLoad
		$I->comment("Entering Action Group [filterCategoryBySecondOption] StorefrontFilterCategoryPageByAttributeOptionActionGroup");
		$I->waitForElementVisible("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createDropdownProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", 30); // stepKey: waitForFilterVisibleFilterCategoryBySecondOption
		$I->conditionalClick("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createDropdownProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", ".filter-options-item.active .items", false); // stepKey: clickToExpandFilterFilterCategoryBySecondOption
		$I->click("//div[@class='filter-options']//li[@class='item']//a[contains(text(), '" . $I->retrieveEntityField('getSecondDropdownProductAttributeOption', 'label', 'test') . "')]"); // stepKey: clickOnOptionFilterCategoryBySecondOption
		$I->waitForPageLoad(30); // stepKey: clickOnOptionFilterCategoryBySecondOptionWaitForPageLoad
		$I->comment("Exiting Action Group [filterCategoryBySecondOption] StorefrontFilterCategoryPageByAttributeOptionActionGroup");
		$I->comment("Entering Action Group [assertFilterBySecondOption] StorefrontAssertAppliedFilterActionGroup");
		$I->see($I->retrieveEntityField('createDropdownProductAttribute', 'attribute[frontend_labels][0][label]', 'test'), ".filter-current .items > li.item:nth-of-type(1) > span.filter-label"); // stepKey: seeAppliedFilterLabelAssertFilterBySecondOption
		$I->see($I->retrieveEntityField('getSecondDropdownProductAttributeOption', 'label', 'test'), ".filter-current .items > li.item:nth-of-type(1) > span.filter-value"); // stepKey: seeAppliedFilterValueAssertFilterBySecondOption
		$I->comment("Exiting Action Group [assertFilterBySecondOption] StorefrontAssertAppliedFilterActionGroup");
		$I->comment("Entering Action Group [assertSecondProductOnCatalogPage] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createSecondProduct', 'name', 'test') . "')]", 30); // stepKey: assertProductNameAssertSecondProductOnCatalogPage
		$I->comment("Exiting Action Group [assertSecondProductOnCatalogPage] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->comment("Entering Action Group [assertFirstProductIsMissingOnCatalogPage] StorefrontCheckProductIsMissingInCategoryProductsPageActionGroup");
		$I->dontSee("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createFirstProduct', 'name', 'test') . "')]"); // stepKey: dontSeeCorrectProductsOnStorefrontAssertFirstProductIsMissingOnCatalogPage
		$I->comment("Exiting Action Group [assertFirstProductIsMissingOnCatalogPage] StorefrontCheckProductIsMissingInCategoryProductsPageActionGroup");
	}
}
