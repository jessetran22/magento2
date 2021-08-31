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
 * @Title("[NO TESTCASEID]: Product Review is Available in Customer's Account")
 * @Description("Customer should be able see product review on My Product Reviews page in Customer account<h3>Test files</h3>app/code/Magento/Review/Test/Mftf/Test/StorefrontVerifyProductReviewInCustomerAccountTest.xml<br>")
 */
class StorefrontVerifyProductReviewInCustomerAccountTestCest
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
        $this->helperContainer->create("\Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->createEntity("category", "hook", "SimpleSubCategory", [], []); // stepKey: category
		$I->createEntity("createProduct1", "hook", "SimpleProduct", ["category"], []); // stepKey: createProduct1
		$I->createEntity("createProduct2", "hook", "SimpleProduct", ["category"], []); // stepKey: createProduct2
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
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
		$I->comment("Entering Action Group [clearNickNameReviewFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearNickNameReviewFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearNickNameReviewFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearNickNameReviewFilters] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [deleteCustomer] AdminDeleteCustomerActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: navigateToCustomersPageDeleteCustomer
		$I->conditionalClick(".admin__data-grid-header .action-tertiary.action-clear", ".admin__data-grid-header .action-tertiary.action-clear", true); // stepKey: clickClearFiltersDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFiltersClearDeleteCustomer
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: openFiltersDeleteCustomerWaitForPageLoad
		$I->fillField("input[name=email]", msq("CustomerEntityOne") . "test@email.com"); // stepKey: fillEmailDeleteCustomer
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteCustomerWaitForPageLoad
		$I->click("//*[contains(text(),'" . msq("CustomerEntityOne") . "test@email.com')]/parent::td/preceding-sibling::td/label[@class='data-grid-checkbox-cell-inner']//input"); // stepKey: chooseCustomerDeleteCustomer
		$I->click(".admin__data-grid-header-row .action-select"); // stepKey: openActionsDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: waitActionsDeleteCustomer
		$I->click("//*[contains(@class, 'admin__data-grid-header')]//span[contains(@class,'action-menu-item') and text()='Delete']"); // stepKey: deleteDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: waitForConfirmationAlertDeleteCustomer
		$I->click("//button[@data-role='action']//span[text()='OK']"); // stepKey: acceptDeleteCustomer
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageDeleteCustomer
		$I->see("A total of 1 record(s) were deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: waitForCustomersGridIsLoadedDeleteCustomer
		$I->comment("Exiting Action Group [deleteCustomer] AdminDeleteCustomerActionGroup");
		$I->deleteEntity("createProduct1", "hook"); // stepKey: deleteProduct1
		$I->deleteEntity("createProduct2", "hook"); // stepKey: deleteProduct2
		$I->deleteEntity("category", "hook"); // stepKey: deleteCategory
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
	 * @Features({"Review"})
	 * @Stories({"Product Review"})
	 * @Severity(level = SeverityLevel::TRIVIAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontVerifyProductReviewInCustomerAccountTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [signUpNewUser] SignUpNewUserFromStorefrontActionGroup");
		$I->amOnPage("/"); // stepKey: amOnStorefrontPageSignUpNewUser
		$I->waitForElementVisible("//div[@class='panel wrapper']//li/a[contains(.,'Create an Account')]", 30); // stepKey: waitForCreateAccountLinkSignUpNewUser
		$I->waitForPageLoad(30); // stepKey: waitForCreateAccountLinkSignUpNewUserWaitForPageLoad
		$I->click("//div[@class='panel wrapper']//li/a[contains(.,'Create an Account')]"); // stepKey: clickOnCreateAccountLinkSignUpNewUser
		$I->waitForPageLoad(30); // stepKey: clickOnCreateAccountLinkSignUpNewUserWaitForPageLoad
		$I->fillField("#firstname", "John"); // stepKey: fillFirstNameSignUpNewUser
		$I->fillField("#lastname", "Doe"); // stepKey: fillLastNameSignUpNewUser
		$I->fillField("#email_address", msq("CustomerEntityOne") . "test@email.com"); // stepKey: fillEmailSignUpNewUser
		$I->fillField("#password", "pwdTest123!"); // stepKey: fillPasswordSignUpNewUser
		$I->fillField("#password-confirmation", "pwdTest123!"); // stepKey: fillConfirmPasswordSignUpNewUser
		$I->waitForPageLoad(30); // stepKey: waitForCreateAccountButtonIsActiveSignUpNewUser
		$I->click("button.action.submit.primary"); // stepKey: clickCreateAccountButtonSignUpNewUser
		$I->waitForPageLoad(30); // stepKey: clickCreateAccountButtonSignUpNewUserWaitForPageLoad
		$I->see("Thank you for registering with Main Website Store."); // stepKey: seeThankYouMessageSignUpNewUser
		$I->see("John", ".box.box-information .box-content"); // stepKey: seeFirstNameSignUpNewUser
		$I->see("Doe", ".box.box-information .box-content"); // stepKey: seeLastNameSignUpNewUser
		$I->see(msq("CustomerEntityOne") . "test@email.com", ".box.box-information .box-content"); // stepKey: seeEmailSignUpNewUser
		$I->comment("Exiting Action Group [signUpNewUser] SignUpNewUserFromStorefrontActionGroup");
		$I->comment("Entering Action Group [openStorefrontProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageOpenStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenStorefrontProductPage
		$I->comment("Exiting Action Group [openStorefrontProductPage] StorefrontOpenProductPageActionGroup");
		$I->comment("Entering Action Group [addReview] StorefrontAddProductReviewActionGroup");
		$I->click("#tab-label-reviews-title"); // stepKey: openReviewTabAddReview
		$I->fillField("#nickname_field", "user" . msq("simpleProductReview")); // stepKey: fillNicknameFieldAddReview
		$I->fillField("#summary_field", "Review title"); // stepKey: fillSummaryFieldAddReview
		$I->fillField("#review_field", "Simple product review"); // stepKey: fillReviewFieldAddReview
		$I->click(".submit"); // stepKey: clickSubmitReviewAddReview
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForSuccessMessageAddReview
		$I->see("You submitted your review for moderation.", "div.message-success"); // stepKey: seeSuccessMessageAddReview
		$I->comment("Exiting Action Group [addReview] StorefrontAddProductReviewActionGroup");
		$I->comment("Entering Action Group [openReviewsPage] AdminOpenPendingReviewsPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/review/product/pending/"); // stepKey: openReviewsPageActionGroupOpenReviewsPage
		$I->waitForPageLoad(30); // stepKey: waitForReviewsPageLoadOpenReviewsPage
		$I->comment("Exiting Action Group [openReviewsPage] AdminOpenPendingReviewsPageActionGroup");
		$I->comment("Entering Action Group [clearFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearFilters] ClearFiltersAdminDataGridActionGroup");
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
		$I->comment("Entering Action Group [navigateToProductReviewsPage] StorefrontNavigateToMyProductReviewsPageActionGroup");
		$I->amOnPage("/review/customer/"); // stepKey: goToMyProductReviewsPageNavigateToProductReviewsPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadNavigateToProductReviewsPage
		$I->comment("Exiting Action Group [navigateToProductReviewsPage] StorefrontNavigateToMyProductReviewsPageActionGroup");
		$I->comment("Entering Action Group [assertReviewInCustomerAccount] AssertStorefrontReviewAtProductReviewPageActionGroup");
		$I->see("Simple product review", "//td[@data-th='Review']"); // stepKey: seeReviewDescriptionAssertReviewInCustomerAccount
		$I->comment("Exiting Action Group [assertReviewInCustomerAccount] AssertStorefrontReviewAtProductReviewPageActionGroup");
	}
}
