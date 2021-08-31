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
 * @Title("MC-25667: Update category, sort products by default sorting")
 * @Description("Login as admin, update category and sort products<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminUpdateCategoryWithProductsDefaultSortingTest.xml<br>")
 * @TestCaseId("MC-25667")
 * @group catalog
 * @group mtf_migrated
 */
class AdminUpdateCategoryWithProductsDefaultSortingTestCest
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
		$I->createEntity("simpleProduct", "hook", "defaultSimpleProduct", [], []); // stepKey: simpleProduct
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->comment("Entering Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [loginToAdminPanel] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("simpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
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
	 * @Features({"Catalog"})
	 * @Stories({"Update categories"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUpdateCategoryWithProductsDefaultSortingTest(AcceptanceTester $I)
	{
		$I->comment("Open Category Page");
		$I->comment("Entering Action Group [goToAdminCategoryPage] GoToAdminCategoryPageByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/edit/id/" . $I->retrieveEntityField('createCategory', 'id', 'test') . "/"); // stepKey: amOnAdminCategoryPageGoToAdminCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToAdminCategoryPage
		$I->see($I->retrieveEntityField('createCategory', 'id', 'test'), ".page-header h1.page-title"); // stepKey: seeCategoryPageTitleGoToAdminCategoryPage
		$I->comment("Exiting Action Group [goToAdminCategoryPage] GoToAdminCategoryPageByIdActionGroup");
		$I->comment("Update Product Display Setting");
		$I->waitForElementVisible("//*[contains(text(),'Display Settings')]", 30); // stepKey: waitForDisplaySettingsSection
		$I->waitForPageLoad(30); // stepKey: waitForDisplaySettingsSectionWaitForPageLoad
		$I->conditionalClick("//*[contains(text(),'Display Settings')]", "//*[@name='display_mode']", false); // stepKey: openDisplaySettingsSection
		$I->waitForElementVisible("input[name='use_config[available_sort_by]']", 30); // stepKey: waitForAvailableProductListCheckbox
		$I->click("input[name='use_config[available_sort_by]']"); // stepKey: enableTheAvailableProductList
		$I->selectOption("select[name='available_sort_by']", ['Product Name',  'Price']); // stepKey: selectPrice
		$I->waitForElementVisible("input[name='use_config[default_sort_by]']", 30); // stepKey: waitForDefaultProductList
		$I->click("input[name='use_config[default_sort_by]']"); // stepKey: enableTheDefaultProductList
		$I->selectOption("select[name='default_sort_by']", "name"); // stepKey: selectProductName
		$I->comment("Add Products in Category");
		$I->comment("Entering Action Group [assignSimpleProductToCategory] AdminCategoryAssignProductActionGroup");
		$I->conditionalClick("div[data-index='assign_products']", ".admin__data-grid-header [data-action='grid-filter-reset']", false); // stepKey: clickOnProductInCategoryAssignSimpleProductToCategory
		$I->waitForPageLoad(30); // stepKey: clickOnProductInCategoryAssignSimpleProductToCategoryWaitForPageLoad
		$I->scrollTo("div[data-index='assign_products']", 0, -80); // stepKey: scrollToProductGridAssignSimpleProductToCategory
		$I->waitForPageLoad(30); // stepKey: scrollToProductGridAssignSimpleProductToCategoryWaitForPageLoad
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: clickOnResetFilterAssignSimpleProductToCategory
		$I->waitForPageLoad(30); // stepKey: clickOnResetFilterAssignSimpleProductToCategoryWaitForPageLoad
		$I->fillField("#catalog_category_products_filter_sku", $I->retrieveEntityField('simpleProduct', 'sku', 'test')); // stepKey: fillSkuFilterAssignSimpleProductToCategory
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickSearchButtonAssignSimpleProductToCategory
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonAssignSimpleProductToCategoryWaitForPageLoad
		$I->click("#catalog_category_products_table tbody tr"); // stepKey: selectProductFromTableRowAssignSimpleProductToCategory
		$I->comment("Exiting Action Group [assignSimpleProductToCategory] AdminCategoryAssignProductActionGroup");
		$I->comment("Entering Action Group [saveCategory] AdminSaveCategoryFormActionGroup");
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: seeOnCategoryPageSaveCategory
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfTheCategoryPageSaveCategory
		$I->click("#save"); // stepKey: saveCategorySaveCategory
		$I->waitForPageLoad(30); // stepKey: saveCategorySaveCategoryWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageAppearsSaveCategory
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveCategory
		$I->see("You saved the category.", "#messages div.message-success"); // stepKey: assertSuccessMessageSaveCategory
		$I->comment("Exiting Action Group [saveCategory] AdminSaveCategoryFormActionGroup");
		$I->comment("Verify Category Title");
		$I->see("simpleCategory" . msq("_defaultCategory"), "h1.page-title"); // stepKey: seeCategoryNamePageTitle
		$I->comment("Verify Category in store front page");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openStorefrontCategoryPage
		$I->comment("Verify Product in Category");
		$I->comment("Entering Action Group [assertSimpleProductOnCategoryPage] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('simpleProduct', 'name', 'test') . "')]", 30); // stepKey: assertProductNameAssertSimpleProductOnCategoryPage
		$I->comment("Exiting Action Group [assertSimpleProductOnCategoryPage] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->comment("Verify product name and sku on Store Front");
		$I->comment("Entering Action Group [assertProductOnStorefrontProductPage] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Go to storefront product page, assert product name and sku");
		$I->amOnPage($I->retrieveEntityField('simpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPageAssertProductOnStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2AssertProductOnStorefrontProductPage
		$I->seeInTitle($I->retrieveEntityField('simpleProduct', 'name', 'test')); // stepKey: assertProductNameTitleAssertProductOnStorefrontProductPage
		$I->see($I->retrieveEntityField('simpleProduct', 'name', 'test'), ".base"); // stepKey: assertProductNameAssertProductOnStorefrontProductPage
		$I->see($I->retrieveEntityField('simpleProduct', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuAssertProductOnStorefrontProductPage
		$I->comment("Exiting Action Group [assertProductOnStorefrontProductPage] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
	}
}
