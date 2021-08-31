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
 * @Title("MC-17229: Adding new category from product page by restricted user")
 * @Description("Adding new category from product page by restricted user<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminRestrictedUserAddCategoryFromProductPageTest.xml<br>")
 * @TestCaseId("MC-17229")
 * @group catalog
 */
class AdminRestrictedUserAddCategoryFromProductPageTestCest
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
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Create category");
		$I->comment("Create category");
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete created product");
		$I->comment("Delete created product");
		$I->comment("Entering Action Group [deleteProduct] DeleteProductBySkuActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteProduct
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteProduct
		$I->fillField("input.admin__control-text[name='sku']", "testSku" . msq("_defaultProduct")); // stepKey: fillProductSkuFilterDeleteProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteProductWaitForPageLoad
		$I->see("testSku" . msq("_defaultProduct"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteProduct
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteProduct
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteProductWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForConfirmModalDeleteProduct
		$I->waitForPageLoad(60); // stepKey: waitForConfirmModalDeleteProductWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmProductDeleteDeleteProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteProductWaitForPageLoad
		$I->see("record(s) have been deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteProduct
		$I->comment("Exiting Action Group [deleteProduct] DeleteProductBySkuActionGroup");
		$I->comment("Entering Action Group [resetFiltersIfExist] ResetProductGridToDefaultViewActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersResetFiltersIfExist
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersResetFiltersIfExistWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabResetFiltersIfExist
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewResetFiltersIfExist
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewResetFiltersIfExistWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductGridLoadResetFiltersIfExist
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedResetFiltersIfExist
		$I->comment("Exiting Action Group [resetFiltersIfExist] ResetProductGridToDefaultViewActionGroup");
		$I->comment("Entering Action Group [logoutOfUser] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutOfUser
		$I->comment("Exiting Action Group [logoutOfUser] AdminLogoutActionGroup");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Delete created data");
		$I->comment("Delete created data");
		$I->comment("Entering Action Group [deleteUserRole] AdminDeleteUserRoleActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user_role/"); // stepKey: navigateToUserRolesGridDeleteUserRole
		$I->fillField("#roleGrid_filter_role_name", "adminRole" . msq("adminRole")); // stepKey: enterRoleNameDeleteUserRole
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickSearchDeleteUserRole
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteUserRoleWaitForPageLoad
		$I->see("adminRole" . msq("adminRole"), "table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: seeUserRoleDeleteUserRole
		$I->click("table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: openRoleEditPageDeleteUserRole
		$I->waitForPageLoad(30); // stepKey: waitForRoleEditPageLoadDeleteUserRole
		$I->fillField("#current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: enterThePasswordDeleteUserRole
		$I->click("button[title='Delete Role']"); // stepKey: deleteUserRoleDeleteUserRole
		$I->waitForElementVisible("aside.confirm .modal-content", 30); // stepKey: waitForConfirmModalDeleteUserRole
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmDeleteDeleteUserRole
		$I->waitForPageLoad(60); // stepKey: confirmDeleteDeleteUserRoleWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageDeleteUserRole
		$I->see("You deleted the role.", "#messages div.message-success"); // stepKey: seeUserRoleDeleteMessageDeleteUserRole
		$I->comment("Exiting Action Group [deleteUserRole] AdminDeleteUserRoleActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/"); // stepKey: goToAllUsersPage
		$I->waitForPageLoad(30); // stepKey: waitForUsersGridLoad
		$I->comment("Entering Action Group [deleteUser] AdminDeleteNewUserActionGroup");
		$I->click("//td[contains(text(), 'admin" . msq("admin2") . "')]"); // stepKey: clickOnUserDeleteUser
		$I->fillField("#user_current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: typeCurrentPasswordDeleteUser
		$I->scrollToTopOfPage(); // stepKey: scrollToTopDeleteUser
		$I->click("//button/span[contains(text(), 'Delete User')]"); // stepKey: clickToDeleteUserDeleteUser
		$I->waitForPageLoad(5); // stepKey: waitForDeletePopupOpenDeleteUser
		$I->click(".action-primary.action-accept"); // stepKey: clickToConfirmDeleteUser
		$I->waitForPageLoad(10); // stepKey: waitForPageLoadDeleteUser
		$I->see("You deleted the user."); // stepKey: seeSuccessMessageDeleteUser
		$I->comment("Exiting Action Group [deleteUser] AdminDeleteNewUserActionGroup");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [logoutOfAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutOfAdmin
		$I->comment("Exiting Action Group [logoutOfAdmin] AdminLogoutActionGroup");
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
	 * @Stories({"Category"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminRestrictedUserAddCategoryFromProductPageTest(AcceptanceTester $I)
	{
		$I->comment("Create user role");
		$I->comment("Create user role");
		$I->comment("Entering Action Group [fillUserRoleRequiredData] AdminFillUserRoleRequiredDataActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user_role/editrole"); // stepKey: navigateToNewRoleFillUserRoleRequiredData
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1FillUserRoleRequiredData
		$I->fillField("#role_name", "adminRole" . msq("adminRole")); // stepKey: fillRoleNameFillUserRoleRequiredData
		$I->fillField("#current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: enterPasswordFillUserRoleRequiredData
		$I->comment("Exiting Action Group [fillUserRoleRequiredData] AdminFillUserRoleRequiredDataActionGroup");
		$I->click("#role_info_tabs_account"); // stepKey: clickRoleResourcesTab
		$I->comment("Entering Action Group [addRestrictedRoleStores] AdminAddRestrictedRoleActionGroup");
		$I->selectOption("#all", "0"); // stepKey: selectResourceAccessCustomAddRestrictedRoleStores
		$I->scrollTo("//*[text()='Stores']//*[@class='jstree-checkbox']", 0, -100); // stepKey: scrollToResourceElementAddRestrictedRoleStores
		$I->waitForElementVisible("//*[text()='Stores']//*[@class='jstree-checkbox']", 30); // stepKey: waitForElementVisibleAddRestrictedRoleStores
		$I->click("//*[text()='Stores']//*[@class='jstree-checkbox']"); // stepKey: clickContentBlockCheckboxAddRestrictedRoleStores
		$I->comment("Exiting Action Group [addRestrictedRoleStores] AdminAddRestrictedRoleActionGroup");
		$I->comment("Entering Action Group [addRestrictedRoleProducts] AdminAddRestrictedRoleActionGroup");
		$I->selectOption("#all", "0"); // stepKey: selectResourceAccessCustomAddRestrictedRoleProducts
		$I->scrollTo("//*[text()='Products']//*[@class='jstree-checkbox']", 0, -100); // stepKey: scrollToResourceElementAddRestrictedRoleProducts
		$I->waitForElementVisible("//*[text()='Products']//*[@class='jstree-checkbox']", 30); // stepKey: waitForElementVisibleAddRestrictedRoleProducts
		$I->click("//*[text()='Products']//*[@class='jstree-checkbox']"); // stepKey: clickContentBlockCheckboxAddRestrictedRoleProducts
		$I->comment("Exiting Action Group [addRestrictedRoleProducts] AdminAddRestrictedRoleActionGroup");
		$I->click("button[title='Save Role']"); // stepKey: clickSaveRoleButton
		$I->waitForPageLoad(30); // stepKey: clickSaveRoleButtonWaitForPageLoad
		$I->see("You saved the role."); // stepKey: seeUserRoleSavedMessage
		$I->comment("Create user and assign role to it");
		$I->comment("Create user and assign role to it");
		$I->comment("Entering Action Group [createAdminUser] AdminCreateUserActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/"); // stepKey: amOnAdminUsersPageCreateAdminUser
		$I->waitForPageLoad(30); // stepKey: waitForAdminUserPageLoadCreateAdminUser
		$I->click("#add"); // stepKey: clickToCreateNewUserCreateAdminUser
		$I->fillField("#user_username", "admin" . msq("admin2")); // stepKey: enterUserNameCreateAdminUser
		$I->fillField("#user_firstname", "John"); // stepKey: enterFirstNameCreateAdminUser
		$I->fillField("#user_lastname", "Smith"); // stepKey: enterLastNameCreateAdminUser
		$I->fillField("#user_email", "admin" . msq("admin2") . "@magento.com"); // stepKey: enterEmailCreateAdminUser
		$I->fillField("#user_password", "admin123"); // stepKey: enterPasswordCreateAdminUser
		$I->fillField("#user_confirmation", "admin123"); // stepKey: confirmPasswordCreateAdminUser
		$I->fillField("#user_current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: enterCurrentPasswordCreateAdminUser
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageCreateAdminUser
		$I->click("#page_tabs_roles_section"); // stepKey: clickUserRoleCreateAdminUser
		$I->waitForPageLoad(30); // stepKey: waitForAdminUserRoleTabLoadCreateAdminUser
		$I->fillField("#permissionsUserRolesGrid_filter_role_name", "adminRole" . msq("adminRole")); // stepKey: filterRoleCreateAdminUser
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchCreateAdminUser
		$I->waitForPageLoad(30); // stepKey: waitForLoadingMaskToDisappear1CreateAdminUser
		$I->click(".data-grid>tbody>tr"); // stepKey: selectRoleCreateAdminUser
		$I->click("#save"); // stepKey: clickSaveUserCreateAdminUser
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2CreateAdminUser
		$I->see("You saved the user."); // stepKey: seeSuccessMessageCreateAdminUser
		$I->comment("Exiting Action Group [createAdminUser] AdminCreateUserActionGroup");
		$I->comment("Log out of admin and login with newly created user");
		$I->comment("Log out of admin and login with newly created user");
		$I->comment("Entering Action Group [logoutOfAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutOfAdmin
		$I->comment("Exiting Action Group [logoutOfAdmin] AdminLogoutActionGroup");
		$I->comment("Entering Action Group [loginAsNewUser] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsNewUser
		$I->fillField("#username", "admin" . msq("admin2")); // stepKey: fillUsernameLoginAsNewUser
		$I->fillField("#login", "admin123"); // stepKey: fillPasswordLoginAsNewUser
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsNewUser
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsNewUserWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsNewUser
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsNewUser
		$I->comment("Exiting Action Group [loginAsNewUser] AdminLoginActionGroup");
		$I->comment("Go to create product page");
		$I->comment("Go to create product page");
		$I->comment("Entering Action Group [goToCreateProductPage] GoToCreateProductPageActionGroup");
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductToggleGoToCreateProductPage
		$I->waitForPageLoad(30); // stepKey: clickAddProductToggleGoToCreateProductPageWaitForPageLoad
		$I->waitForElementVisible(".item[data-ui-id='products-list-add-new-product-button-item-simple']", 30); // stepKey: waitForAddProductDropdownGoToCreateProductPage
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-simple']"); // stepKey: clickAddProductTypeGoToCreateProductPage
		$I->waitForPageLoad(30); // stepKey: waitForCreateProductPageLoadGoToCreateProductPage
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/simple/"); // stepKey: seeNewProductUrlGoToCreateProductPage
		$I->see("New Product", ".page-header h1.page-title"); // stepKey: seeNewProductTitleGoToCreateProductPage
		$I->comment("Exiting Action Group [goToCreateProductPage] GoToCreateProductPageActionGroup");
		$I->dontSeeElement("button[data-index='create_category_button']"); // stepKey: dontSeeNewCategoryButton
		$I->waitForPageLoad(30); // stepKey: dontSeeNewCategoryButtonWaitForPageLoad
		$I->comment("Fill product data and assign to category");
		$I->comment("Fill product data and assign to category");
		$I->comment("Entering Action Group [fillMainProductForm] FillMainProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageFillMainProductForm
		$I->fillField(".admin__field[data-index=name] input", "testProductName" . msq("_defaultProduct")); // stepKey: fillProductNameFillMainProductForm
		$I->fillField(".admin__field[data-index=sku] input", "testSku" . msq("_defaultProduct")); // stepKey: fillProductSkuFillMainProductForm
		$I->fillField(".admin__field[data-index=price] input", "123.00"); // stepKey: fillProductPriceFillMainProductForm
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillProductQtyFillMainProductForm
		$I->selectOption("select[name='product[quantity_and_stock_status][is_in_stock]']", "1"); // stepKey: selectStockStatusFillMainProductForm
		$I->waitForPageLoad(30); // stepKey: selectStockStatusFillMainProductFormWaitForPageLoad
		$I->selectOption("select[name='product[product_has_weight]']", "This item has weight"); // stepKey: selectWeightFillMainProductForm
		$I->fillField(".admin__field[data-index=weight] input", "1"); // stepKey: fillProductWeightFillMainProductForm
		$I->comment("Exiting Action Group [fillMainProductForm] FillMainProductFormActionGroup");
		$I->comment("Entering Action Group [addCategoryToProduct] SetCategoryByNameActionGroup");
		$I->searchAndMultiSelectOption("div[data-index='category_ids']", [$I->retrieveEntityField('createCategory', 'name', 'test')]); // stepKey: searchAndSelectCategoryAddCategoryToProduct
		$I->waitForPageLoad(30); // stepKey: searchAndSelectCategoryAddCategoryToProductWaitForPageLoad
		$I->comment("Exiting Action Group [addCategoryToProduct] SetCategoryByNameActionGroup");
		$I->comment("Entering Action Group [saveProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct
		$I->comment("Exiting Action Group [saveProduct] SaveProductFormActionGroup");
		$I->comment("Assert that category exist in field");
		$I->comment("Assert that category exist in field");
		$grabCategoryName = $I->grabTextFrom("div[data-index='category_ids']"); // stepKey: grabCategoryName
		$I->waitForPageLoad(30); // stepKey: grabCategoryNameWaitForPageLoad
		$I->assertStringContainsString($I->retrieveEntityField('createCategory', 'name', 'test'), $grabCategoryName); // stepKey: assertThatCategory
		$I->comment("Remove the category from the product and assert that it removed");
		$I->comment("Remove the category from the product and assert that it removed");
		$I->comment("Entering Action Group [removeCategoryFromProduct] RemoveCategoryFromProductActionGroup");
		$I->click("div[data-index='category_ids']"); // stepKey: clickCategoriesDropDownRemoveCategoryFromProduct
		$I->waitForPageLoad(30); // stepKey: clickCategoriesDropDownRemoveCategoryFromProductWaitForPageLoad
		$I->click("//span[@class='admin__action-multiselect-crumb']/span[contains(.,'" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]/../button[@data-action='remove-selected-item']"); // stepKey: unselectCategoriesRemoveCategoryFromProduct
		$I->waitForPageLoad(30); // stepKey: unselectCategoriesRemoveCategoryFromProductWaitForPageLoad
		$I->click("//*[@data-index='category_ids']//button[@data-action='close-advanced-select']"); // stepKey: clickOnDoneAdvancedCategoryRemoveCategoryFromProduct
		$I->waitForPageLoad(30); // stepKey: clickOnDoneAdvancedCategoryRemoveCategoryFromProductWaitForPageLoad
		$I->comment("Exiting Action Group [removeCategoryFromProduct] RemoveCategoryFromProductActionGroup");
		$I->comment("Entering Action Group [saveProductAfterRemovingCategory] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProductAfterRemovingCategory
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProductAfterRemovingCategory
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductAfterRemovingCategoryWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProductAfterRemovingCategory
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductAfterRemovingCategoryWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProductAfterRemovingCategory
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProductAfterRemovingCategory
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProductAfterRemovingCategory
		$I->comment("Exiting Action Group [saveProductAfterRemovingCategory] SaveProductFormActionGroup");
		$grabCategoryFieldContent = $I->grabTextFrom("div[data-index='category_ids']"); // stepKey: grabCategoryFieldContent
		$I->waitForPageLoad(30); // stepKey: grabCategoryFieldContentWaitForPageLoad
		$I->assertStringNotContainsString($I->retrieveEntityField('createCategory', 'name', 'test'), $grabCategoryFieldContent); // stepKey: assertThatCategoryRemoved
	}
}
