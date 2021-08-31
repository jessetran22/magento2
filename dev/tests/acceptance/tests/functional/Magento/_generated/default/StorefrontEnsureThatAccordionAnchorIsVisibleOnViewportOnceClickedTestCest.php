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
 * @Title("MC-6484: Ensure that accordion anchor is visible on viewport once clicked")
 * @Description("Ensure that accordion anchor is visible on viewport once clicked<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/StorefrontEnsureThatAccordionAnchorIsVisibleOnViewportOnceClickedTest.xml<br>")
 * @TestCaseId("MC-6484")
 * @group Catalog
 */
class StorefrontEnsureThatAccordionAnchorIsVisibleOnViewportOnceClickedTestCest
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
		$I->comment("Create product with description");
		$I->createEntity("createProduct", "hook", "SimpleProductWithDescription", [], []); // stepKey: createProduct
		$I->comment("Create 4 product attributes visible on front end");
		$I->createEntity("createFirstAttribute", "hook", "productDropDownAttribute", [], []); // stepKey: createFirstAttribute
		$I->createEntity("createOption", "hook", "productAttributeOption1", ["createFirstAttribute"], []); // stepKey: createOption
		$I->createEntity("createSecondAttribute", "hook", "productAttributeText", [], []); // stepKey: createSecondAttribute
		$I->createEntity("createThirdAttribute", "hook", "newProductAttribute", [], []); // stepKey: createThirdAttribute
		$I->createEntity("createFourthAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createFourthAttribute
		$I->createEntity("createFirstOption", "hook", "productAttributeOption1", ["createFourthAttribute"], []); // stepKey: createFirstOption
		$I->createEntity("createSecondOption", "hook", "productAttributeOption2", ["createFourthAttribute"], []); // stepKey: createSecondOption
		$I->comment("Add all created attributes to Default Attribute Set");
		$I->createEntity("addFirstAttributeToAttributeSet", "hook", "AddToDefaultSet", ["createFirstAttribute"], []); // stepKey: addFirstAttributeToAttributeSet
		$I->createEntity("addSecondAttributeToAttributeSet", "hook", "AddToDefaultSet", ["createSecondAttribute"], []); // stepKey: addSecondAttributeToAttributeSet
		$I->createEntity("addThirdAttributeToAttributeSet", "hook", "AddToDefaultSet", ["createThirdAttribute"], []); // stepKey: addThirdAttributeToAttributeSet
		$I->createEntity("addFourthAttributeToAttributeSet", "hook", "AddToDefaultSet", ["createFourthAttribute"], []); // stepKey: addFourthAttributeToAttributeSet
		$I->comment("Login as admin");
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
		$I->comment("Delete reviews");
		$I->comment("Entering Action Group [openAllReviewsPage] AdminOpenReviewsPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/review/product/index/"); // stepKey: openReviewsPageActionGroupOpenAllReviewsPage
		$I->waitForPageLoad(30); // stepKey: waitForReviewsPageLoadOpenAllReviewsPage
		$I->comment("Exiting Action Group [openAllReviewsPage] AdminOpenReviewsPageActionGroup");
		$I->comment("Entering Action Group [deleteCustomerReview] AdminDeleteReviewsByUserNicknameActionGroup");
		$I->fillField("#reviewGrid_filter_nickname", "user" . msq("simpleProductReview")); // stepKey: fillNicknameDeleteCustomerReview
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteCustomerReview
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteCustomerReviewWaitForPageLoad
		$I->selectOption("#reviewGrid_massaction-mass-select", "selectAll"); // stepKey: selectAllDeleteCustomerReview
		$I->selectOption("#reviewGrid_massaction-select", "delete"); // stepKey: clickDeleteActionDropdownDeleteCustomerReview
		$I->click(".admin__grid-massaction-form .action-default.scalable"); // stepKey: clickSubmitDeleteCustomerReview
		$I->waitForElementVisible(".modal-popup.confirm button.action-accept", 30); // stepKey: waitForModalPopUpDeleteCustomerReview
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteCustomerReview
		$I->see("record(s) have been deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteCustomerReview
		$I->comment("Exiting Action Group [deleteCustomerReview] AdminDeleteReviewsByUserNicknameActionGroup");
		$I->comment("Delete customer");
		$I->comment("Entering Action Group [deleteCustomer] DeleteCustomerByEmailActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: navigateToCustomersDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: waitForAdminCustomerPageLoadDeleteCustomer
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: clickFilterButtonDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: clickFilterButtonDeleteCustomerWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: cleanFiltersIfTheySetDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: cleanFiltersIfTheySetDeleteCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersDeleteCustomer
		$I->fillField("input[name=email]", msq("CustomerEntityOne") . "test@email.com"); // stepKey: filterEmailDeleteCustomer
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: applyFilterDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: applyFilterDeleteCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadDeleteCustomer
		$I->click("//td[@class='data-grid-checkbox-cell']"); // stepKey: clickOnEditButton1DeleteCustomer
		$I->click("//div[@class='col-xs-2']/div[@class='action-select-wrap']/button[@class='action-select']"); // stepKey: clickActionsDropdownDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: clickActionsDropdownDeleteCustomerWaitForPageLoad
		$I->click("//*[contains(@class,'admin__data-grid-header-row row row-gutter')]//*[text()='Delete']"); // stepKey: clickDeleteDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: clickDeleteDeleteCustomerWaitForPageLoad
		$I->waitForElementVisible("//button[@data-role='action']//span[text()='OK']", 30); // stepKey: waitForOkToVisibleDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: waitForOkToVisibleDeleteCustomerWaitForPageLoad
		$I->click("//button[@data-role='action']//span[text()='OK']"); // stepKey: clickOkConfirmationButtonDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: clickOkConfirmationButtonDeleteCustomerWaitForPageLoad
		$I->waitForElementVisible("//*[@class='message message-success success']", 30); // stepKey: waitForSuccessfullyDeletedMessageDeleteCustomer
		$I->comment("Exiting Action Group [deleteCustomer] DeleteCustomerByEmailActionGroup");
		$I->deleteEntity("createFirstAttribute", "hook"); // stepKey: deleteFirstAttribute
		$I->deleteEntity("createSecondAttribute", "hook"); // stepKey: deleteSecondAttribute
		$I->deleteEntity("createThirdAttribute", "hook"); // stepKey: deleteThirdAttribute
		$I->deleteEntity("createFourthAttribute", "hook"); // stepKey: deleteFourthAttribute
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->comment("Reindex invalidated indices after product attribute has been created/deleted");
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
	 * @Stories({"Ensure that accordion anchor is visible on viewport once clicked"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontEnsureThatAccordionAnchorIsVisibleOnViewportOnceClickedTest(AcceptanceTester $I)
	{
		$I->comment("Edit the product and set those attributes values");
		$I->comment("Entering Action Group [findCreatedProductInGrid] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexFindCreatedProductInGrid
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadFindCreatedProductInGrid
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageFindCreatedProductInGrid
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetFindCreatedProductInGrid
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetFindCreatedProductInGridWaitForPageLoad
		$I->fillField("input[name=sku]", $I->retrieveEntityField('createProduct', 'sku', 'test')); // stepKey: fillSkuFieldOnFiltersSectionFindCreatedProductInGrid
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonFindCreatedProductInGrid
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonFindCreatedProductInGridWaitForPageLoad
		$I->comment("Exiting Action Group [findCreatedProductInGrid] SearchForProductOnBackendActionGroup");
		$I->comment("Entering Action Group [goToEditProductPage] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createProduct', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowGoToEditProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadGoToEditProductPage
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('createProduct', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageGoToEditProductPage
		$I->comment("Exiting Action Group [goToEditProductPage] OpenEditProductOnBackendActionGroup");
		$I->selectOption("//select[@name='product[" . $I->retrieveEntityField('createFirstAttribute', 'attribute[attribute_code]', 'test') . "]']", $I->retrieveEntityField('createOption', 'option[store_labels][0][label]', 'test')); // stepKey: setFirstAttributeValue
		$I->fillField("//input[@name='product[" . $I->retrieveEntityField('createSecondAttribute', 'attribute[attribute_code]', 'test') . "]']", "white" . msq("ProductAttributeOption8")); // stepKey: setSecondAttributeValue
		$I->fillField("//input[@name='product[" . $I->retrieveEntityField('createThirdAttribute', 'attribute[attribute_code]', 'test') . "]']", "white" . msq("ProductAttributeOption8")); // stepKey: setThirdAttributeValue
		$I->selectOption("//select[@name='product[" . $I->retrieveEntityField('createFourthAttribute', 'attribute[attribute_code]', 'test') . "]']", $I->retrieveEntityField('createSecondOption', 'option[store_labels][0][label]', 'test')); // stepKey: setFourthAttributeValue
		$I->comment("Save product form");
		$I->comment("Entering Action Group [saveSimpleProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveSimpleProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveSimpleProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveSimpleProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveSimpleProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveSimpleProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveSimpleProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveSimpleProduct
		$I->comment("Exiting Action Group [saveSimpleProduct] SaveProductFormActionGroup");
		$I->comment("Go to frontend and make a user account and login with it");
		$I->comment("Entering Action Group [openCreateAccountPage] StorefrontOpenCustomerAccountCreatePageActionGroup");
		$I->amOnPage("/customer/account/create/"); // stepKey: goToCustomerAccountCreatePageOpenCreateAccountPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedOpenCreateAccountPage
		$I->comment("Exiting Action Group [openCreateAccountPage] StorefrontOpenCustomerAccountCreatePageActionGroup");
		$I->comment("Entering Action Group [fillCreateAccountForm] StorefrontFillCustomerAccountCreationFormActionGroup");
		$I->fillField("#firstname", "John"); // stepKey: fillFirstNameFillCreateAccountForm
		$I->fillField("#lastname", "Doe"); // stepKey: fillLastNameFillCreateAccountForm
		$I->fillField("#email_address", msq("CustomerEntityOne") . "test@email.com"); // stepKey: fillEmailFillCreateAccountForm
		$I->fillField("#password", "pwdTest123!"); // stepKey: fillPasswordFillCreateAccountForm
		$I->fillField("#password-confirmation", "pwdTest123!"); // stepKey: fillConfirmPasswordFillCreateAccountForm
		$I->comment("Exiting Action Group [fillCreateAccountForm] StorefrontFillCustomerAccountCreationFormActionGroup");
		$I->comment("Entering Action Group [submitCreateAccountForm] StorefrontClickCreateAnAccountCustomerAccountCreationFormActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForCreateAccountButtonIsActiveSubmitCreateAccountForm
		$I->click("button.action.submit.primary"); // stepKey: clickCreateAccountButtonSubmitCreateAccountForm
		$I->waitForPageLoad(30); // stepKey: clickCreateAccountButtonSubmitCreateAccountFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerSavedSubmitCreateAccountForm
		$I->comment("Exiting Action Group [submitCreateAccountForm] StorefrontClickCreateAnAccountCustomerAccountCreationFormActionGroup");
		$I->comment("Entering Action Group [seeSuccessMessage] AssertMessageCustomerCreateAccountActionGroup");
		$I->see("Thank you for registering with Main Website Store.", "#maincontent .message-success"); // stepKey: verifyMessageSeeSuccessMessage
		$I->comment("Exiting Action Group [seeSuccessMessage] AssertMessageCustomerCreateAccountActionGroup");
		$I->comment("Go to the product view page");
		$I->comment("Entering Action Group [openCreatedProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageOpenCreatedProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenCreatedProductPage
		$I->comment("Exiting Action Group [openCreatedProductPage] StorefrontOpenProductPageActionGroup");
		$I->comment("Click on reviews and add 2 reviews with current user");
		$I->comment("Entering Action Group [addFirstReview] StorefrontAddProductReviewActionGroup");
		$I->click("#tab-label-reviews-title"); // stepKey: openReviewTabAddFirstReview
		$I->fillField("#nickname_field", "user" . msq("simpleProductReview")); // stepKey: fillNicknameFieldAddFirstReview
		$I->fillField("#summary_field", "Review title"); // stepKey: fillSummaryFieldAddFirstReview
		$I->fillField("#review_field", "Simple product review"); // stepKey: fillReviewFieldAddFirstReview
		$I->click(".submit"); // stepKey: clickSubmitReviewAddFirstReview
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForSuccessMessageAddFirstReview
		$I->see("You submitted your review for moderation.", "div.message-success"); // stepKey: seeSuccessMessageAddFirstReview
		$I->comment("Exiting Action Group [addFirstReview] StorefrontAddProductReviewActionGroup");
		$I->comment("Entering Action Group [addSecondReview] StorefrontAddProductReviewActionGroup");
		$I->click("#tab-label-reviews-title"); // stepKey: openReviewTabAddSecondReview
		$I->fillField("#nickname_field", "user" . msq("simpleProductReview")); // stepKey: fillNicknameFieldAddSecondReview
		$I->fillField("#summary_field", "Review title"); // stepKey: fillSummaryFieldAddSecondReview
		$I->fillField("#review_field", "Simple product review"); // stepKey: fillReviewFieldAddSecondReview
		$I->click(".submit"); // stepKey: clickSubmitReviewAddSecondReview
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForSuccessMessageAddSecondReview
		$I->see("You submitted your review for moderation.", "div.message-success"); // stepKey: seeSuccessMessageAddSecondReview
		$I->comment("Exiting Action Group [addSecondReview] StorefrontAddProductReviewActionGroup");
		$I->comment("Go to Pending reviews page and clear filters");
		$I->comment("Entering Action Group [openReviewsPage] AdminOpenPendingReviewsPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/review/product/pending/"); // stepKey: openReviewsPageActionGroupOpenReviewsPage
		$I->waitForPageLoad(30); // stepKey: waitForReviewsPageLoadOpenReviewsPage
		$I->comment("Exiting Action Group [openReviewsPage] AdminOpenPendingReviewsPageActionGroup");
		$I->comment("Entering Action Group [clearFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearFilters] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Moderate first product reviews: change review status from pending to approved, save");
		$I->comment("Entering Action Group [openFirstCustomerReviews] AdminOpenReviewByUserNicknameActionGroup");
		$I->fillField("#reviewGrid_filter_nickname", "user" . msq("simpleProductReview")); // stepKey: fillNicknameOpenFirstCustomerReviews
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersOpenFirstCustomerReviews
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersOpenFirstCustomerReviewsWaitForPageLoad
		$I->click(".data-grid tbody tr:nth-of-type(1)"); // stepKey: clickFirstRowOpenFirstCustomerReviews
		$I->waitForPageLoad(30); // stepKey: waitForEditReviewPageLoadOpenFirstCustomerReviews
		$I->comment("Exiting Action Group [openFirstCustomerReviews] AdminOpenReviewByUserNicknameActionGroup");
		$I->comment("Entering Action Group [changeFirstReviewStatus] AdminChangeReviewStatusActionGroup");
		$I->selectOption("#status_id", "1"); // stepKey: changeReviewStatusChangeFirstReviewStatus
		$I->comment("Exiting Action Group [changeFirstReviewStatus] AdminChangeReviewStatusActionGroup");
		$I->comment("Entering Action Group [saveModeratedFirstReview] AdminSaveReviewActionGroup");
		$I->click("#save_button"); // stepKey: saveReviewSaveModeratedFirstReview
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageSaveModeratedFirstReview
		$I->see("You saved the review.", "#messages div.message-success"); // stepKey: seeSuccessMessageSaveModeratedFirstReview
		$I->comment("Exiting Action Group [saveModeratedFirstReview] AdminSaveReviewActionGroup");
		$I->comment("Moderate second product reviews: change review status from pending to approved, save");
		$I->comment("Entering Action Group [clearFilter] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearFilter
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearFilterWaitForPageLoad
		$I->comment("Exiting Action Group [clearFilter] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [openSecondCustomerReviews] AdminOpenReviewByUserNicknameActionGroup");
		$I->fillField("#reviewGrid_filter_nickname", "user" . msq("simpleProductReview")); // stepKey: fillNicknameOpenSecondCustomerReviews
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersOpenSecondCustomerReviews
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersOpenSecondCustomerReviewsWaitForPageLoad
		$I->click(".data-grid tbody tr:nth-of-type(1)"); // stepKey: clickFirstRowOpenSecondCustomerReviews
		$I->waitForPageLoad(30); // stepKey: waitForEditReviewPageLoadOpenSecondCustomerReviews
		$I->comment("Exiting Action Group [openSecondCustomerReviews] AdminOpenReviewByUserNicknameActionGroup");
		$I->comment("Entering Action Group [changeSecondReviewStatus] AdminChangeReviewStatusActionGroup");
		$I->selectOption("#status_id", "1"); // stepKey: changeReviewStatusChangeSecondReviewStatus
		$I->comment("Exiting Action Group [changeSecondReviewStatus] AdminChangeReviewStatusActionGroup");
		$I->comment("Entering Action Group [saveModeratedSecondReview] AdminSaveReviewActionGroup");
		$I->click("#save_button"); // stepKey: saveReviewSaveModeratedSecondReview
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageSaveModeratedSecondReview
		$I->see("You saved the review.", "#messages div.message-success"); // stepKey: seeSuccessMessageSaveModeratedSecondReview
		$I->comment("Exiting Action Group [saveModeratedSecondReview] AdminSaveReviewActionGroup");
		$I->comment("Assert that product page has the description");
		$I->comment("Entering Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageOpenProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductPage
		$I->comment("Exiting Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->click("#tab-label-description-title"); // stepKey: clickDetailsTab
		$I->see($I->retrieveEntityField('createProduct', 'custom_attributes[description]', 'test'), "#description .value"); // stepKey: assertProductDescription
		$I->comment("Assert that product page has added reviews");
		$I->click("#tab-label-reviews-title"); // stepKey: clickReviewTab
		$I->waitForElementVisible("#customer-reviews", 30); // stepKey: seeAllReviews
		$I->comment("Entering Action Group [assertFirstReview] StorefrontAssertReviewAtProductPageActionGroup");
		$I->see("Review title", ".item.review-item:nth-of-type(1) .review-title"); // stepKey: seeReviewTitleAssertFirstReview
		$I->see("Simple product review", ".item.review-item:nth-of-type(1) .review-content"); // stepKey: seeReviewContentAssertFirstReview
		$I->see("user" . msq("simpleProductReview"), ".item.review-item:nth-of-type(1) .review-author .review-details-value"); // stepKey: seeAuthorReviewAssertFirstReview
		$I->comment("Exiting Action Group [assertFirstReview] StorefrontAssertReviewAtProductPageActionGroup");
		$I->comment("Entering Action Group [assertSecondReview] StorefrontAssertReviewAtProductPageActionGroup");
		$I->see("Review title", ".item.review-item:nth-of-type(2) .review-title"); // stepKey: seeReviewTitleAssertSecondReview
		$I->see("Simple product review", ".item.review-item:nth-of-type(2) .review-content"); // stepKey: seeReviewContentAssertSecondReview
		$I->see("user" . msq("simpleProductReview"), ".item.review-item:nth-of-type(2) .review-author .review-details-value"); // stepKey: seeAuthorReviewAssertSecondReview
		$I->comment("Exiting Action Group [assertSecondReview] StorefrontAssertReviewAtProductPageActionGroup");
		$I->comment("Assert that product page has all product attributes in More Info tab");
		$I->comment("Entering Action Group [checkFirstAttributeInMoreInformationTab] CheckAttributeInMoreInformationTabActionGroup");
		$I->click("#tab-label-additional-title"); // stepKey: clickTabCheckFirstAttributeInMoreInformationTab
		$I->waitForPageLoad(30); // stepKey: clickTabCheckFirstAttributeInMoreInformationTabWaitForPageLoad
		$I->see($I->retrieveEntityField('createFirstAttribute', 'attribute[frontend_labels][0][label]', 'test'), "#additional"); // stepKey: seeAttributeLabelCheckFirstAttributeInMoreInformationTab
		$I->see($I->retrieveEntityField('createOption', 'option[store_labels][0][label]', 'test'), "#additional"); // stepKey: seeAttributeValueCheckFirstAttributeInMoreInformationTab
		$I->comment("Exiting Action Group [checkFirstAttributeInMoreInformationTab] CheckAttributeInMoreInformationTabActionGroup");
		$I->comment("Entering Action Group [checkSecondAttributeInMoreInformationTab] CheckAttributeInMoreInformationTabActionGroup");
		$I->click("#tab-label-additional-title"); // stepKey: clickTabCheckSecondAttributeInMoreInformationTab
		$I->waitForPageLoad(30); // stepKey: clickTabCheckSecondAttributeInMoreInformationTabWaitForPageLoad
		$I->see($I->retrieveEntityField('createSecondAttribute', 'attribute[frontend_labels][0][label]', 'test'), "#additional"); // stepKey: seeAttributeLabelCheckSecondAttributeInMoreInformationTab
		$I->see("white" . msq("ProductAttributeOption8"), "#additional"); // stepKey: seeAttributeValueCheckSecondAttributeInMoreInformationTab
		$I->comment("Exiting Action Group [checkSecondAttributeInMoreInformationTab] CheckAttributeInMoreInformationTabActionGroup");
		$I->comment("Entering Action Group [checkThirdAttributeInMoreInformationTab] CheckAttributeInMoreInformationTabActionGroup");
		$I->click("#tab-label-additional-title"); // stepKey: clickTabCheckThirdAttributeInMoreInformationTab
		$I->waitForPageLoad(30); // stepKey: clickTabCheckThirdAttributeInMoreInformationTabWaitForPageLoad
		$I->see($I->retrieveEntityField('createThirdAttribute', 'attribute[frontend_labels][0][label]', 'test'), "#additional"); // stepKey: seeAttributeLabelCheckThirdAttributeInMoreInformationTab
		$I->see("white" . msq("ProductAttributeOption8"), "#additional"); // stepKey: seeAttributeValueCheckThirdAttributeInMoreInformationTab
		$I->comment("Exiting Action Group [checkThirdAttributeInMoreInformationTab] CheckAttributeInMoreInformationTabActionGroup");
		$I->comment("Entering Action Group [checkFourthAttributeInMoreInformationTab] CheckAttributeInMoreInformationTabActionGroup");
		$I->click("#tab-label-additional-title"); // stepKey: clickTabCheckFourthAttributeInMoreInformationTab
		$I->waitForPageLoad(30); // stepKey: clickTabCheckFourthAttributeInMoreInformationTabWaitForPageLoad
		$I->see($I->retrieveEntityField('createFourthAttribute', 'attribute[frontend_labels][0][label]', 'test'), "#additional"); // stepKey: seeAttributeLabelCheckFourthAttributeInMoreInformationTab
		$I->see($I->retrieveEntityField('createSecondOption', 'option[store_labels][0][label]', 'test'), "#additional"); // stepKey: seeAttributeValueCheckFourthAttributeInMoreInformationTab
		$I->comment("Exiting Action Group [checkFourthAttributeInMoreInformationTab] CheckAttributeInMoreInformationTabActionGroup");
		$I->comment("Collapse the view of the page to minimum width so that mobile view becomes visible");
		$I->resizeWindow(400, 590); // stepKey: resizeWindowToMobileView
		$I->comment("Assert that Details tab on product page become accordion");
		$I->click("#tab-label-description-title"); // stepKey: clickDetails
		$I->seeElement("//*[@id='tab-label-description-title']/ancestor::div[@aria-selected='true'][@aria-expanded='true']"); // stepKey: seeOpenDetailsTab
		$I->seeElement("//*[@id='tab-label-additional-title']/ancestor::div[@aria-selected='false'][@aria-expanded='false']"); // stepKey: seeClosedMoreInformationTab
		$I->seeElement("//*[@id='tab-label-reviews-title']/ancestor::div[@aria-selected='false'][@aria-expanded='false']"); // stepKey: seeClosedReviewTab
		$I->comment("Assert that More Information tab on product page become accordion");
		$I->click("#tab-label-additional-title"); // stepKey: clickMoreInformation
		$I->waitForPageLoad(30); // stepKey: clickMoreInformationWaitForPageLoad
		$I->seeElement("//*[@id='tab-label-description-title']/ancestor::div[@aria-selected='false'][@aria-expanded='false']"); // stepKey: seeClosedDetails
		$I->seeElement("//*[@id='tab-label-additional-title']/ancestor::div[@aria-selected='true'][@aria-expanded='true']"); // stepKey: seeOpenMoreInformationTab
		$I->seeElement("//*[@id='tab-label-reviews-title']/ancestor::div[@aria-selected='false'][@aria-expanded='false']"); // stepKey: seeClosedReview
		$I->comment("Assert that Reviews tab on product page become accordion");
		$I->click("#tab-label-reviews-title"); // stepKey: clickReview
		$I->seeElement("//*[@id='tab-label-description-title']/ancestor::div[@aria-selected='false'][@aria-expanded='false']"); // stepKey: seeClosedDetailsTab
		$I->seeElement("//*[@id='tab-label-additional-title']/ancestor::div[@aria-selected='false'][@aria-expanded='false']"); // stepKey: seeClosedMoreInformation
		$I->seeElement("//*[@id='tab-label-reviews-title']/ancestor::div[@aria-selected='true'][@aria-expanded='true']"); // stepKey: seeOpenReviewTab
		$I->comment("Scroll so that the description is visible and More info tab is on the upper middle of the page");
		$I->scrollTo("#tab-label-description-title"); // stepKey: scrollToMoreInfoTab
		$I->resizeWindow(1280, 1024); // stepKey: resizeWindowToDesktop
	}
}
