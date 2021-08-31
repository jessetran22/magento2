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
 * @Title("MC-234: Admin should be able to create category from the product page")
 * @Description("Admin should be able to create category from the product page<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCreateCategoryFromProductPageTest.xml<br>")
 * @TestCaseId("MC-234")
 * @group Catalog
 */
class AdminCreateCategoryFromProductPageTestCest
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
		$I->comment("Login as admin");
		$I->createEntity("simpleProduct", "hook", "SimpleTwo", [], []); // stepKey: simpleProduct
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete the created category");
		$I->comment("Entering Action Group [getRidOfCreatedCategory] DeleteMostRecentCategoryActionGroup");
		$I->amOnPage("/" . (getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: goToCategoryFrontPageGetRidOfCreatedCategory
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadGetRidOfCreatedCategory
		$I->click(".x-tree-root-ct li li:last-child"); // stepKey: goToCreateCategoryGetRidOfCreatedCategory
		$I->waitForPageLoad(30); // stepKey: waitForCreatedCategoryPageLoadGetRidOfCreatedCategory
		$I->click(".page-actions-inner #delete"); // stepKey: clickDeleteCategoryGetRidOfCreatedCategory
		$I->waitForPageLoad(30); // stepKey: clickDeleteCategoryGetRidOfCreatedCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForModalVisibleGetRidOfCreatedCategory
		$I->click("aside.confirm .modal-footer .action-primary"); // stepKey: clickOkToDeleteGetRidOfCreatedCategory
		$I->waitForPageLoad(30); // stepKey: waitForModalNotVisibleGetRidOfCreatedCategory
		$I->comment("Exiting Action Group [getRidOfCreatedCategory] DeleteMostRecentCategoryActionGroup");
		$I->comment("Entering Action Group [amOnLogoutPage] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAmOnLogoutPage
		$I->comment("Exiting Action Group [amOnLogoutPage] AdminLogoutActionGroup");
		$I->deleteEntity("simpleProduct", "hook"); // stepKey: deleteProduct
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
	 * @Stories({"Create/Edit Category in Admin"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateCategoryFromProductPageTest(AcceptanceTester $I)
	{
		$I->comment("Find the product that we just created using the product grid and go to its page");
		$I->comment("Entering Action Group [visitAdminProductPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageVisitAdminProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadVisitAdminProductPage
		$I->comment("Exiting Action Group [visitAdminProductPage] AdminOpenProductIndexPageActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitial
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialWaitForPageLoad
		$I->comment("Entering Action Group [findCreatedProduct] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFindCreatedProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFindCreatedProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFindCreatedProduct
		$I->fillField("input.admin__control-text[name='sku']", "SimpleTwo" . msq("SimpleTwo")); // stepKey: fillProductSkuFilterFindCreatedProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFindCreatedProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFindCreatedProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFindCreatedProduct
		$I->comment("Exiting Action Group [findCreatedProduct] FilterProductGridBySkuActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForFiltersToBeApplied
		$I->comment("Entering Action Group [clickOnProductPage] AdminProductGridSectionClickFirstRowActionGroup");
		$I->click("tr.data-row:nth-of-type(1)"); // stepKey: clickOnProductPageClickOnProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadClickOnProductPage
		$I->comment("Exiting Action Group [clickOnProductPage] AdminProductGridSectionClickFirstRowActionGroup");
		$I->comment("Fill out the form for the new category");
		$I->comment("Entering Action Group [FillNewProductCategory] FillNewProductCategoryActionGroup");
		$I->comment("Click on new Category");
		$I->click("//button/span[text()='New Category']"); // stepKey: clickNewCategoryFillNewProductCategory
		$I->waitForPageLoad(30); // stepKey: waitForFieldSetFillNewProductCategory
		$I->fillField("input[name='name']", "simpleCategory" . msq("_defaultCategory")); // stepKey: fillCategoryNameFillNewProductCategory
		$I->comment("Search and select a parent category for the product");
		$I->click(".product_form_product_form_create_category_modal div[data-role='selected-option']"); // stepKey: clickParentCategoryFillNewProductCategory
		$I->waitForPageLoad(30); // stepKey: waitForDropDownVisibleFillNewProductCategory
		$I->fillField("aside input[data-role='advanced-select-text']", "default"); // stepKey: searchForParentFillNewProductCategory
		$I->waitForPageLoad(30); // stepKey: waitForFieldResultsFillNewProductCategory
		$I->click("aside .admin__action-multiselect-menu-inner"); // stepKey: clickParentFillNewProductCategory
		$I->click("#save"); // stepKey: createCategoryFillNewProductCategory
		$I->waitForPageLoad(30); // stepKey: createCategoryFillNewProductCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryCreatedFillNewProductCategory
		$I->comment("Exiting Action Group [FillNewProductCategory] FillNewProductCategoryActionGroup");
		$I->comment("Check that category was created");
		$I->comment("Entering Action Group [checkIfCategoryPresent] CategoryPresentActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: goToCategoryAdminPageCheckIfCategoryPresent
		$I->waitForPageLoad(30); // stepKey: waitForCategoryAdminPageLoadCheckIfCategoryPresent
		$I->see("simpleCategory" . msq("_defaultCategory"), ".tree-holder"); // stepKey: assertCategoryOnAdminPageCheckIfCategoryPresent
		$I->amOnPage("/simpleCategory" . msq("_defaultCategory") . ".html"); // stepKey: goToCustomerFrontPageCheckIfCategoryPresent
		$I->see("simpleCategory" . msq("_defaultCategory"), "#page-title-heading span"); // stepKey: assertCategoryNameOnStorefrontCheckIfCategoryPresent
		$I->waitForPageLoad(30); // stepKey: waitForCustomerCategoryPageLoadCheckIfCategoryPresent
		$I->comment("Exiting Action Group [checkIfCategoryPresent] CategoryPresentActionGroup");
	}
}
