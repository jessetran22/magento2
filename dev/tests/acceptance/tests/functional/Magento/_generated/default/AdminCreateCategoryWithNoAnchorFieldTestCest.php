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
 * @Title(": Create no anchor subcategory with all fields")
 * @Description("Login as admin and create no anchor subcategory with all fields<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCreateCategoryWithNoAnchorFieldTest.xml<br>")
 * @TestCaseId("")
 * @group Catalog
 * @group mtf_migrated
 */
class AdminCreateCategoryWithNoAnchorFieldTestCest
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
		$I->comment("Entering Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->createEntity("createDefaultCMSBlock", "hook", "_defaultBlock", [], []); // stepKey: createDefaultCMSBlock
		$I->createEntity("simpleProduct", "hook", "defaultSimpleProduct", [], []); // stepKey: simpleProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteCategory] DeleteCategoryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: goToCategoryPageDeleteCategory
		$I->waitForPageLoad(60); // stepKey: waitForCategoryPageLoadDeleteCategory
		$I->click("//a/span[contains(text(), 'simpleCategory" . msq("_defaultCategory") . "')]"); // stepKey: clickCategoryLinkDeleteCategory
		$I->waitForPageLoad(30); // stepKey: clickCategoryLinkDeleteCategoryWaitForPageLoad
		$I->click(".page-actions-inner #delete"); // stepKey: clickDeleteDeleteCategory
		$I->waitForPageLoad(30); // stepKey: clickDeleteDeleteCategoryWaitForPageLoad
		$I->waitForElementVisible("aside.confirm div.modal-content", 30); // stepKey: waitForConfirmationModalDeleteCategory
		$I->see("Are you sure you want to delete this category?", "aside.confirm div.modal-content"); // stepKey: seeDeleteConfirmationMessageDeleteCategory
		$I->click("aside.confirm .modal-footer .action-primary"); // stepKey: confirmDeleteDeleteCategory
		$I->waitForPageLoad(60); // stepKey: waitForDeleteToFinishDeleteCategory
		$I->see("You deleted the category."); // stepKey: seeDeleteSuccessDeleteCategory
		$I->click(".tree-actions a:last-child"); // stepKey: expandToSeeAllCategoriesDeleteCategory
		$I->dontSee("//a/span[contains(text(), 'simpleCategory" . msq("_defaultCategory") . "')]"); // stepKey: dontSeeCategoryInTreeDeleteCategory
		$I->waitForPageLoad(30); // stepKey: dontSeeCategoryInTreeDeleteCategoryWaitForPageLoad
		$I->comment("Exiting Action Group [deleteCategory] DeleteCategoryActionGroup");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->deleteEntity("createDefaultCMSBlock", "hook"); // stepKey: deleteDefaultCMSBlock
		$I->deleteEntity("simpleProduct", "hook"); // stepKey: deleteSimpleProduct
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
	 * @Stories({"Create categories"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateCategoryWithNoAnchorFieldTest(AcceptanceTester $I)
	{
		$I->comment("Create  SubCategory");
		$I->comment("Entering Action Group [openAdminCategoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageOpenAdminCategoryIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadOpenAdminCategoryIndexPage
		$I->comment("Exiting Action Group [openAdminCategoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->click("#add_subcategory_button"); // stepKey: clickOnAddSubCategoryButton
		$I->waitForPageLoad(30); // stepKey: clickOnAddSubCategoryButtonWaitForPageLoad
		$I->fillField("input[name='name']", "simpleCategory" . msq("_defaultCategory")); // stepKey: fillCategoryName
		$I->checkOption("input[name='is_active']"); // stepKey: enableCategory
		$I->comment("Select Content and fill the options");
		$I->scrollTo("div[data-index='content']", 0, -80); // stepKey: scrollToContent
		$I->waitForPageLoad(30); // stepKey: scrollToContentWaitForPageLoad
		$I->click("div[data-index='content']"); // stepKey: selectContent
		$I->waitForPageLoad(30); // stepKey: selectContentWaitForPageLoad
		$I->scrollTo("//*[@name='landing_page']", 0, -80); // stepKey: scrollToAddCMSBlock
		$I->selectOption("//*[@name='landing_page']", $I->retrieveEntityField('createDefaultCMSBlock', 'title', 'test')); // stepKey: selectCMSBlock
		$I->comment("Select Display Setting and fill the options");
		$I->scrollTo("//strong[@class='admin__collapsible-title']//span[text()='Display Settings']", 0, -80); // stepKey: scrollToDisplaySetting
		$I->click("//strong[@class='admin__collapsible-title']//span[text()='Display Settings']"); // stepKey: selectDisplaySetting
		$I->selectOption("select[name='display_mode']", "PRODUCTS_AND_PAGE"); // stepKey: selectdisplayMode
		$I->click("input[name='is_anchor']+label"); // stepKey: uncheckAnchor
		$I->click("input[name='use_config[available_sort_by]']"); // stepKey: enableTheAvailableProductList
		$I->selectOption("select[name='available_sort_by']", ['Position',  'Product Name',  'Price']); // stepKey: selectPrice
		$I->scrollTo("input[name='use_config[default_sort_by]']", 0, -80); // stepKey: scrollToDefaultProductList
		$I->click("input[name='use_config[default_sort_by]']"); // stepKey: enableTheDefaultProductList
		$I->selectOption("select[name='default_sort_by']", "name"); // stepKey: selectProductName
		$I->scrollTo("input[name='use_config[filter_price_range]']", 0, -80); // stepKey: scrollToLayeredNavPrice
		$I->click("input[name='use_config[filter_price_range]']"); // stepKey: enableLayeredNavigationPrice
		$I->fillField("input[name='filter_price_range']", "5.5"); // stepKey: fillThePrice
		$I->comment("Search the products and select the category products");
		$I->comment("Entering Action Group [addProductToCategory] AdminAddProductToCategoryActionGroup");
		$I->scrollTo("div[data-index='assign_products']", 0, -80); // stepKey: scrollToProductInCategoryAddProductToCategory
		$I->waitForPageLoad(30); // stepKey: scrollToProductInCategoryAddProductToCategoryWaitForPageLoad
		$I->click("div[data-index='assign_products']"); // stepKey: clickOnProductInCategoryAddProductToCategory
		$I->waitForPageLoad(30); // stepKey: clickOnProductInCategoryAddProductToCategoryWaitForPageLoad
		$I->fillField("#catalog_category_products_filter_name", $I->retrieveEntityField('simpleProduct', 'name', 'test')); // stepKey: selectProductAddProductToCategory
		$I->click("//button[@data-action='grid-filter-apply']"); // stepKey: clickSearchButtonAddProductToCategory
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonAddProductToCategoryWaitForPageLoad
		$I->click("#catalog_category_products_table tbody tr"); // stepKey: selectProductFromTableRowAddProductToCategory
		$I->comment("Exiting Action Group [addProductToCategory] AdminAddProductToCategoryActionGroup");
		$I->comment("Entering Action Group [clickSaveButton] AdminSaveCategoryActionGroup");
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryWithProductsClickSaveButton
		$I->waitForPageLoad(30); // stepKey: saveCategoryWithProductsClickSaveButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategorySavedClickSaveButton
		$I->comment("Exiting Action Group [clickSaveButton] AdminSaveCategoryActionGroup");
		$I->comment("Entering Action Group [assertSuccessMessage] AssertAdminCategorySaveSuccessMessageActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForElementAssertSuccessMessage
		$I->see("You saved the category.", "#messages div.message-success"); // stepKey: seeSuccessMessageAssertSuccessMessage
		$I->comment("Exiting Action Group [assertSuccessMessage] AssertAdminCategorySaveSuccessMessageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageTitleToBeSaved
		$I->comment("Get Category ID");
		$I->comment("Entering Action Group [getCategoryId] OpenCategoryFromCategoryTreeActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageGetCategoryId
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadGetCategoryId
		$I->click(".tree-actions a:last-child"); // stepKey: clickOnExpandTreeGetCategoryId
		$I->waitForPageLoad(30); // stepKey: waitForCategoryToLoadGetCategoryId
		$I->click("//a/span[contains(text(), 'simpleCategory" . msq("_defaultCategory") . "')]"); // stepKey: selectCategoryGetCategoryId
		$I->waitForPageLoad(30); // stepKey: selectCategoryGetCategoryIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGetCategoryId
		$I->waitForElementVisible("h1.page-title", 30); // stepKey: waitForCategoryTitleGetCategoryId
		$I->comment("Exiting Action Group [getCategoryId] OpenCategoryFromCategoryTreeActionGroup");
		$categoryId = $I->grabFromCurrentUrl("#\/([0-9]*)?\/$#"); // stepKey: categoryId
		$I->comment("Verify the Category Title");
		$I->see("simpleCategory" . msq("_defaultCategory"), "h1.page-title"); // stepKey: seePageTitle
		$I->comment("Verify Url Rewrite");
		$I->comment("Entering Action Group [searchByRequestPath] AdminSearchByRequestPathActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteEditPageSearchByRequestPath
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadSearchByRequestPath
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchByRequestPath
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchByRequestPathWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSearchByRequestPath
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFiltersSearchByRequestPath
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersSearchByRequestPathWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", "simplecategory" . msq("_defaultCategory") . ".html"); // stepKey: fillRedirectPathFilterSearchByRequestPath
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersSearchByRequestPath
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersSearchByRequestPathWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1SearchByRequestPath
		$I->see("simplecategory" . msq("_defaultCategory") . ".html", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1]"); // stepKey: seeTheRedirectPathForOldUrlSearchByRequestPath
		$I->see("catalog/category/view/id/{$categoryId}", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Target Path')]/preceding-sibling::th)+1]"); // stepKey: seeTheTargetPathSearchByRequestPath
		$I->see("No", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Redirect Type')]/preceding-sibling::th)+1]"); // stepKey: seeTheRedirectTypeForOldUrlSearchByRequestPath
		$I->comment("Exiting Action Group [searchByRequestPath] AdminSearchByRequestPathActionGroup");
		$I->comment("Verify Product in store front page");
		$I->amOnPage("/simplecategory" . msq("_defaultCategory") . ".html"); // stepKey: amOnCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForPageToBeLoaded
		$I->see("simpleCategory" . msq("_defaultCategory"), "#page-title-heading span"); // stepKey: seeCategoryPageTitle
		$I->seeElement("//nav//a[span[contains(., 'simpleCategory" . msq("_defaultCategory") . "')]]"); // stepKey: seeCategoryOnNavigation
		$I->waitForPageLoad(30); // stepKey: seeCategoryOnNavigationWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoad
		$I->seeElement("a.product-item-link[href$='" . $I->retrieveEntityField('simpleProduct', 'custom_attributes[url_key]', 'test') . ".html']"); // stepKey: seeProductInCategory
		$I->dontSeeElement(".filter-options-content .items"); // stepKey: dontSeeFilterOptionsForNonAnchorCategory
	}
}
