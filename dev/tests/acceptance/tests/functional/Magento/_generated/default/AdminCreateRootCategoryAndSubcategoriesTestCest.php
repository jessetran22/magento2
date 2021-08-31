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
 * @Title("MAGETWO-46142: Admin should be able to create a Root Category and a Subcategory")
 * @Description("Admin should be able to create a Root Category and a Subcategory<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCreateRootCategoryAndSubcategoriesTest.xml<br>")
 * @TestCaseId("MAGETWO-46142")
 * @group category
 */
class AdminCreateRootCategoryAndSubcategoriesTestCest
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
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [loginAsAdmin2] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin2
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin2
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin2
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin2
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdmin2WaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin2
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin2
		$I->comment("Exiting Action Group [loginAsAdmin2] AdminLoginActionGroup");
		$I->comment("Entering Action Group [amOnPageAdminSystemStore] AdminSystemStoreOpenPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToSystemStoreAmOnPageAdminSystemStore
		$I->waitForPageLoad(30); // stepKey: waitForPageAdminSystemStoreLoadAmOnPageAdminSystemStore
		$I->comment("Exiting Action Group [amOnPageAdminSystemStore] AdminSystemStoreOpenPageActionGroup");
		$I->click("button[title='Reset Filter']"); // stepKey: clickOnResetButton
		$I->waitForPageLoad(30); // stepKey: clickOnResetButtonWaitForPageLoad
		$I->waitForPageLoad(10); // stepKey: waitForPageAdminStoresGridLoadAfterResetButton
		$I->fillField("#storeGrid_filter_group_title", "Main Website Store"); // stepKey: fillFieldOnWebsiteStore
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickOnSearchButton
		$I->waitForPageLoad(30); // stepKey: clickOnSearchButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageAdminStoresGridLoadAfterSearchButton
		$I->click(".col-group_title>a"); // stepKey: clickOnstoreGrpNameInFirstRow
		$I->waitForPageLoad(30); // stepKey: waitForPageAdminSystemStoreLoad1
		$I->selectOption("#group_root_category_id", "Default Category"); // stepKey: selectOptionDefaultCategory
		$I->click("#save"); // stepKey: clickSaveStoreButton
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreButtonWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickOkOnModalDialog2
		$I->waitForPageLoad(60); // stepKey: clickOkOnModalDialog2WaitForPageLoad
		$I->comment("Entering Action Group [deleteCreatedNewRootCategory] DeleteCategoryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: goToCategoryPageDeleteCreatedNewRootCategory
		$I->waitForPageLoad(60); // stepKey: waitForCategoryPageLoadDeleteCreatedNewRootCategory
		$I->click("//a/span[contains(text(), 'NewRootCategory" . msq("NewRootCategory") . "')]"); // stepKey: clickCategoryLinkDeleteCreatedNewRootCategory
		$I->waitForPageLoad(30); // stepKey: clickCategoryLinkDeleteCreatedNewRootCategoryWaitForPageLoad
		$I->click(".page-actions-inner #delete"); // stepKey: clickDeleteDeleteCreatedNewRootCategory
		$I->waitForPageLoad(30); // stepKey: clickDeleteDeleteCreatedNewRootCategoryWaitForPageLoad
		$I->waitForElementVisible("aside.confirm div.modal-content", 30); // stepKey: waitForConfirmationModalDeleteCreatedNewRootCategory
		$I->see("Are you sure you want to delete this category?", "aside.confirm div.modal-content"); // stepKey: seeDeleteConfirmationMessageDeleteCreatedNewRootCategory
		$I->click("aside.confirm .modal-footer .action-primary"); // stepKey: confirmDeleteDeleteCreatedNewRootCategory
		$I->waitForPageLoad(60); // stepKey: waitForDeleteToFinishDeleteCreatedNewRootCategory
		$I->see("You deleted the category."); // stepKey: seeDeleteSuccessDeleteCreatedNewRootCategory
		$I->click(".tree-actions a:last-child"); // stepKey: expandToSeeAllCategoriesDeleteCreatedNewRootCategory
		$I->dontSee("//a/span[contains(text(), 'NewRootCategory" . msq("NewRootCategory") . "')]"); // stepKey: dontSeeCategoryInTreeDeleteCreatedNewRootCategory
		$I->waitForPageLoad(30); // stepKey: dontSeeCategoryInTreeDeleteCreatedNewRootCategoryWaitForPageLoad
		$I->comment("Exiting Action Group [deleteCreatedNewRootCategory] DeleteCategoryActionGroup");
		$I->comment("Entering Action Group [logout2] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout2
		$I->comment("Exiting Action Group [logout2] AdminLogoutActionGroup");
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
	 * @Stories({"Create categories"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateRootCategoryAndSubcategoriesTest(AcceptanceTester $I)
	{
		$I->comment("Delete all created data during the test execution and assign Default Root Category to Store");
		$I->comment("Entering Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin1
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin1
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin1
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin1
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdmin1WaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin1
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin1
		$I->comment("Exiting Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->comment("Entering Action Group [amOnAdminCategoryPage] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageAmOnAdminCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadAmOnAdminCategoryPage
		$I->comment("Exiting Action Group [amOnAdminCategoryPage] AdminOpenCategoryPageActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPage1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1
		$I->comment("Create new root category");
		$I->comment("Entering Action Group [createNewRootCategory] AdminCreateRootCategory");
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: seeOnCategoryPageCreateNewRootCategory
		$I->click("#add_root_category_button"); // stepKey: clickOnAddRootCategoryButtonCreateNewRootCategory
		$I->waitForPageLoad(30); // stepKey: clickOnAddRootCategoryButtonCreateNewRootCategoryWaitForPageLoad
		$I->see("New Category", ".page-header h1.page-title"); // stepKey: seeCategoryPageTitleCreateNewRootCategory
		$I->fillField("input[name='name']", "NewRootCategory" . msq("NewRootCategory")); // stepKey: enterNewRootCategoryNameCreateNewRootCategory
		$I->click("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: openSEOCreateNewRootCategory
		$I->waitForPageLoad(30); // stepKey: openSEOCreateNewRootCategoryWaitForPageLoad
		$I->fillField("input[name='url_key']", "newrootcategory" . msq("NewRootCategory")); // stepKey: enterURLKeyCreateNewRootCategory
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryCreateNewRootCategory
		$I->waitForPageLoad(30); // stepKey: saveCategoryCreateNewRootCategoryWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskDisappearCreateNewRootCategory
		$I->seeElement(".message-success"); // stepKey: assertSuccessCreateNewRootCategory
		$I->seeInTitle("NewRootCategory" . msq("NewRootCategory")); // stepKey: seeNewCategoryPageTitleCreateNewRootCategory
		$I->seeElement("//a/span[contains(text(), 'NewRootCategory" . msq("NewRootCategory") . "')]"); // stepKey: seeCategoryInTreeCreateNewRootCategory
		$I->waitForPageLoad(30); // stepKey: seeCategoryInTreeCreateNewRootCategoryWaitForPageLoad
		$I->comment("Exiting Action Group [createNewRootCategory] AdminCreateRootCategory");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPage2
		$I->comment("Create subcategory");
		$I->comment("Entering Action Group [createSubcategory1] CreateCategoryActionGroup");
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: seeOnCategoryPageCreateSubcategory1
		$I->click("#add_subcategory_button"); // stepKey: clickOnAddSubCategoryCreateSubcategory1
		$I->waitForPageLoad(30); // stepKey: clickOnAddSubCategoryCreateSubcategory1WaitForPageLoad
		$I->see("New Category", ".page-header h1.page-title"); // stepKey: seeCategoryPageTitleCreateSubcategory1
		$I->fillField("input[name='name']", "SimpleSubCategory" . msq("SimpleSubCategory")); // stepKey: enterCategoryNameCreateSubcategory1
		$I->click("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: openSEOCreateSubcategory1
		$I->waitForPageLoad(30); // stepKey: openSEOCreateSubcategory1WaitForPageLoad
		$I->fillField("input[name='url_key']", "simplesubcategory" . msq("SimpleSubCategory")); // stepKey: enterURLKeyCreateSubcategory1
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryCreateSubcategory1
		$I->waitForPageLoad(30); // stepKey: saveCategoryCreateSubcategory1WaitForPageLoad
		$I->seeElement(".message-success"); // stepKey: assertSuccessCreateSubcategory1
		$I->seeInTitle("SimpleSubCategory" . msq("SimpleSubCategory")); // stepKey: seeNewCategoryPageTitleCreateSubcategory1
		$I->seeElement("//a/span[contains(text(), 'SimpleSubCategory" . msq("SimpleSubCategory") . "')]"); // stepKey: seeCategoryInTreeCreateSubcategory1
		$I->waitForPageLoad(30); // stepKey: seeCategoryInTreeCreateSubcategory1WaitForPageLoad
		$I->comment("Exiting Action Group [createSubcategory1] CreateCategoryActionGroup");
		$I->click("//a/span[contains(text(), 'NewRootCategory" . msq("NewRootCategory") . "')]"); // stepKey: clickOnCreatedNewRootCategory1
		$I->waitForPageLoad(30); // stepKey: clickOnCreatedNewRootCategory1WaitForPageLoad
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPage3
		$I->comment("Create another subcategory");
		$I->comment("Entering Action Group [createSubcategory2] CreateCategoryActionGroup");
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: seeOnCategoryPageCreateSubcategory2
		$I->click("#add_subcategory_button"); // stepKey: clickOnAddSubCategoryCreateSubcategory2
		$I->waitForPageLoad(30); // stepKey: clickOnAddSubCategoryCreateSubcategory2WaitForPageLoad
		$I->see("New Category", ".page-header h1.page-title"); // stepKey: seeCategoryPageTitleCreateSubcategory2
		$I->fillField("input[name='name']", "subCategory" . msq("SubCategoryWithParent")); // stepKey: enterCategoryNameCreateSubcategory2
		$I->click("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: openSEOCreateSubcategory2
		$I->waitForPageLoad(30); // stepKey: openSEOCreateSubcategory2WaitForPageLoad
		$I->fillField("input[name='url_key']", "subCategory" . msq("SubCategoryWithParent")); // stepKey: enterURLKeyCreateSubcategory2
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryCreateSubcategory2
		$I->waitForPageLoad(30); // stepKey: saveCategoryCreateSubcategory2WaitForPageLoad
		$I->seeElement(".message-success"); // stepKey: assertSuccessCreateSubcategory2
		$I->seeInTitle("subCategory" . msq("SubCategoryWithParent")); // stepKey: seeNewCategoryPageTitleCreateSubcategory2
		$I->seeElement("//a/span[contains(text(), 'subCategory" . msq("SubCategoryWithParent") . "')]"); // stepKey: seeCategoryInTreeCreateSubcategory2
		$I->waitForPageLoad(30); // stepKey: seeCategoryInTreeCreateSubcategory2WaitForPageLoad
		$I->comment("Exiting Action Group [createSubcategory2] CreateCategoryActionGroup");
		$I->comment("Assign new created root category to store");
		$I->comment("Entering Action Group [amOnPageAdminSystemStore] AdminSystemStoreOpenPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToSystemStoreAmOnPageAdminSystemStore
		$I->waitForPageLoad(30); // stepKey: waitForPageAdminSystemStoreLoadAmOnPageAdminSystemStore
		$I->comment("Exiting Action Group [amOnPageAdminSystemStore] AdminSystemStoreOpenPageActionGroup");
		$I->click("button[title='Reset Filter']"); // stepKey: clickOnResetButton
		$I->waitForPageLoad(30); // stepKey: clickOnResetButtonWaitForPageLoad
		$I->waitForPageLoad(10); // stepKey: waitForPageAdminStoresGridLoadAfterResetButton
		$I->fillField("#storeGrid_filter_group_title", "Main Website Store"); // stepKey: fillFieldOnWebsiteStore
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickOnSearchButton
		$I->waitForPageLoad(30); // stepKey: clickOnSearchButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageAdminStoresGridLoadAfterSearchButton
		$I->click(".col-group_title>a"); // stepKey: clickOnstoreGrpNameInFirstRow
		$I->waitForPageLoad(30); // stepKey: waitForPageAdminStoresGroupEditLoad
		$I->selectOption("#group_root_category_id", "NewRootCategory" . msq("NewRootCategory")); // stepKey: selectOptionCreatedNewRootCategory
		$I->click("#save"); // stepKey: clickSaveStoreButton
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreButtonWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickOkOnModalDialog1
		$I->waitForPageLoad(60); // stepKey: clickOkOnModalDialog1WaitForPageLoad
		$I->comment("Entering Action Group [logout1] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout1
		$I->comment("Exiting Action Group [logout1] AdminLogoutActionGroup");
		$I->comment("Go to storefront and verify created subcategory on frontend");
		$I->comment("Entering Action Group [goToHomePage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToHomePage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToHomePage
		$I->comment("Exiting Action Group [goToHomePage] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [checkCreatedSubcategory1OnFrontend] CheckCategoryOnStorefrontActionGroup");
		$I->amOnPage("/simplesubcategory" . msq("SimpleSubCategory") . ".html"); // stepKey: goToCategoryFrontPageCheckCreatedSubcategory1OnFrontend
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CheckCreatedSubcategory1OnFrontend
		$I->see("simplesubcategory" . msq("SimpleSubCategory"), "#page-title-heading span"); // stepKey: assertCategoryOnStorefrontCheckCreatedSubcategory1OnFrontend
		$I->seeInTitle("SimpleSubCategory" . msq("SimpleSubCategory")); // stepKey: seeCategoryNameInTitleCheckCreatedSubcategory1OnFrontend
		$I->comment("Exiting Action Group [checkCreatedSubcategory1OnFrontend] CheckCategoryOnStorefrontActionGroup");
		$I->comment("Entering Action Group [checkCreatedSubcategory2OnFrontend] CheckCategoryOnStorefrontActionGroup");
		$I->amOnPage("/subCategory" . msq("SubCategoryWithParent") . ".html"); // stepKey: goToCategoryFrontPageCheckCreatedSubcategory2OnFrontend
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CheckCreatedSubcategory2OnFrontend
		$I->see("subCategory" . msq("SubCategoryWithParent"), "#page-title-heading span"); // stepKey: assertCategoryOnStorefrontCheckCreatedSubcategory2OnFrontend
		$I->seeInTitle("subCategory" . msq("SubCategoryWithParent")); // stepKey: seeCategoryNameInTitleCheckCreatedSubcategory2OnFrontend
		$I->comment("Exiting Action Group [checkCreatedSubcategory2OnFrontend] CheckCategoryOnStorefrontActionGroup");
	}
}
