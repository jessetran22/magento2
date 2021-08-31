<?php
namespace Magento\AcceptanceTest\_WYSIWYGDisabledSuite\Backend;

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
 * @Title("MC-6058: Update category, name description urlkey metatitle exclude from menu")
 * @Description("Login as admin and update category name, description, urlKey, metatitle and exclude from menu<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminUpdateCategoryWithInactiveIncludeInMenuTest.xml<br>")
 * @TestCaseId("MC-6058")
 * @group Catalog
 * @group mtf_migrated
 * @group WYSIWYGDisabled
 */
class AdminUpdateCategoryWithInactiveIncludeInMenuTestCest
{
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
		$I->createEntity("createDefaultCategory", "hook", "_defaultCategory", [], []); // stepKey: createDefaultCategory
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createDefaultCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
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
	 * @Stories({"Update categories"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUpdateCategoryWithInactiveIncludeInMenuTest(AcceptanceTester $I)
	{
		$I->comment("Open Category Page");
		$I->comment("Entering Action Group [openAdminCategoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageOpenAdminCategoryIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadOpenAdminCategoryIndexPage
		$I->comment("Exiting Action Group [openAdminCategoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->comment("Update Category name,description, urlKey, meta title and disable Include in Menu");
		$I->comment("Entering Action Group [clickOnExpandTree] AdminExpandCategoryTreeActionGroup");
		$I->click(".tree-actions a:last-child"); // stepKey: clickOnExpandTreeClickOnExpandTree
		$I->waitForPageLoad(30); // stepKey: waitForCategoryToLoadClickOnExpandTree
		$I->comment("Exiting Action Group [clickOnExpandTree] AdminExpandCategoryTreeActionGroup");
		$I->click("//a/span[contains(text(), 'simpleCategory" . msq("_defaultCategory") . "')]"); // stepKey: selectCreatedCategory
		$I->waitForPageLoad(30); // stepKey: selectCreatedCategoryWaitForPageLoad
		$I->fillField("input[name='name']", "SimpleRootSubCategory" . msq("SimpleRootSubCategory")); // stepKey: fillCategoryName
		$I->checkOption("input[name='is_active']"); // stepKey: enableCategory
		$I->click("input[name='include_in_menu']+label"); // stepKey: disableIncludeInMenu
		$I->scrollTo("div[data-index='content']", 0, -80); // stepKey: scrollToContent
		$I->waitForPageLoad(30); // stepKey: scrollToContentWaitForPageLoad
		$I->click("div[data-index='content']"); // stepKey: selectContent
		$I->waitForPageLoad(30); // stepKey: selectContentWaitForPageLoad
		$I->scrollTo("//*[@name='description']", 0, -80); // stepKey: scrollToDescription
		$I->fillField("//*[@name='description']", "Updated category Description Fields"); // stepKey: fillUpdatedDescription
		$I->scrollTo("div[data-index='search_engine_optimization'] .fieldset-wrapper-title", 0, -80); // stepKey: scrollToSearchEngineOptimization
		$I->waitForPageLoad(30); // stepKey: scrollToSearchEngineOptimizationWaitForPageLoad
		$I->click("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: selectSearchEngineOptimization
		$I->waitForPageLoad(30); // stepKey: selectSearchEngineOptimizationWaitForPageLoad
		$I->fillField("input[name='url_key']", "simplerootsubcategory" . msq("SimpleRootSubCategory")); // stepKey: fillUpdatedUrlKey
		$I->fillField("input[name='meta_title']", "SimpleRootSubCategory" . msq("SimpleRootSubCategory")); // stepKey: fillUpdatedMetaTitle
		$I->comment("Entering Action Group [clickSaveButton] AdminSaveCategoryActionGroup");
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryWithProductsClickSaveButton
		$I->waitForPageLoad(30); // stepKey: saveCategoryWithProductsClickSaveButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategorySavedClickSaveButton
		$I->comment("Exiting Action Group [clickSaveButton] AdminSaveCategoryActionGroup");
		$I->comment("Entering Action Group [assertSuccessMessage] AssertAdminCategorySaveSuccessMessageActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForElementAssertSuccessMessage
		$I->see("You saved the category.", "#messages div.message-success"); // stepKey: seeSuccessMessageAssertSuccessMessage
		$I->comment("Exiting Action Group [assertSuccessMessage] AssertAdminCategorySaveSuccessMessageActionGroup");
		$I->comment("Open UrlRewrite Page");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewritePage
		$I->comment("Verify Updated Category UrlKey");
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFilters
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", "simplerootsubcategory" . msq("SimpleRootSubCategory")); // stepKey: fillUpdatedCategoryUrlKey
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFilters
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad
		$I->see("simplerootsubcategory" . msq("SimpleRootSubCategory") . ".html", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1]"); // stepKey: seeCategoryUrlKey
		$I->comment("Verify Updated Category UrlKey directs to category Store Front");
		$I->amOnPage("simplerootsubcategory" . msq("SimpleRootSubCategory") . ".html"); // stepKey: seeTheCategoryInStoreFrontPage
		$I->waitForPageLoad(60); // stepKey: waitForStoreFrontPageLoad
		$I->seeElement("#page-title-heading span"); // stepKey: seeUpdatedCategoryInStoreFrontPage
		$I->comment("Verify Updated fields in Category Page");
		$I->comment("Entering Action Group [openAdminCategoryIndexPage1] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageOpenAdminCategoryIndexPage1
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadOpenAdminCategoryIndexPage1
		$I->comment("Exiting Action Group [openAdminCategoryIndexPage1] AdminOpenCategoryPageActionGroup");
		$I->comment("Entering Action Group [clickOnExpandTree1] AdminExpandCategoryTreeActionGroup");
		$I->click(".tree-actions a:last-child"); // stepKey: clickOnExpandTreeClickOnExpandTree1
		$I->waitForPageLoad(30); // stepKey: waitForCategoryToLoadClickOnExpandTree1
		$I->comment("Exiting Action Group [clickOnExpandTree1] AdminExpandCategoryTreeActionGroup");
		$I->click("//a/span[contains(text(), 'SimpleRootSubCategory" . msq("SimpleRootSubCategory") . "')]"); // stepKey: selectCreatedCategory1
		$I->waitForPageLoad(30); // stepKey: selectCreatedCategory1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoad
		$I->see("SimpleRootSubCategory" . msq("SimpleRootSubCategory"), "h1.page-title"); // stepKey: seeUpdatedCategoryTitle
		$I->dontSeeCheckboxIsChecked("input[name='include_in_menu']+label"); // stepKey: verifyInactiveIncludeInMenu
		$I->seeInField("input[name='name']", "SimpleRootSubCategory" . msq("SimpleRootSubCategory")); // stepKey: seeUpdatedCategoryName
		$I->scrollTo("div[data-index='content']", 0, -80); // stepKey: scrollToContent1
		$I->waitForPageLoad(30); // stepKey: scrollToContent1WaitForPageLoad
		$I->click("div[data-index='content']"); // stepKey: selectContent1
		$I->waitForPageLoad(30); // stepKey: selectContent1WaitForPageLoad
		$I->scrollTo("//*[@name='description']"); // stepKey: scrollToDescription1
		$I->seeInField("//*[@name='description']", "Updated category Description Fields"); // stepKey: seeUpdatedDiscription
		$I->scrollTo("div[data-index='search_engine_optimization'] .fieldset-wrapper-title", 0, -80); // stepKey: scrollToSearchEngineOptimization1
		$I->waitForPageLoad(30); // stepKey: scrollToSearchEngineOptimization1WaitForPageLoad
		$I->click("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: selectSearchEngineOptimization1
		$I->waitForPageLoad(30); // stepKey: selectSearchEngineOptimization1WaitForPageLoad
		$I->seeInField("input[name='url_key']", "simplerootsubcategory" . msq("SimpleRootSubCategory")); // stepKey: seeUpdatedUrlKey
		$I->seeInField("input[name='meta_title']", "SimpleRootSubCategory" . msq("SimpleRootSubCategory")); // stepKey: seeUpdatedMetaTitleInput
	}
}
